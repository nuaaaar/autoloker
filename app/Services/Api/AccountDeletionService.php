<?php

namespace App\Services\Api;

use App\Models\User;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountDeletionService
{
    public function __construct(private readonly AccountDeletionFileService $files) {}

    public function delete(User $user): bool
    {
        $ids = DB::transaction(function () use ($user) {
            $locked = User::whereKey($user->id)->lockForUpdate()->first();
            if (! $locked) throw new AuthenticationException();
            if (! in_array($locked->role, ['satpam', 'cs', 'company', 'bujp'], true)) throw new AuthorizationException();

            $sets = [];
            foreach ([
                ['user_securities', 'securities', 'user_security_id'],
                ['user_cleaning_services', 'cleaning_services', 'user_cleaning_service_id'],
                ['user_companies', 'companies', 'user_company_id'],
                ['user_b_u_j_p_s', 'b_u_j_p_s', 'user_b_u_j_p_id'],
            ] as [$bridge, $profile, $foreign]) {
                $bridgeIds = DB::table($bridge)->where('user_id', $locked->id)->lockForUpdate()->pluck('id')->all();
                $sets[$profile] = $bridgeIds ? DB::table($profile)->whereIn($foreign, $bridgeIds)->lockForUpdate()->pluck('id')->all() : [];
                $sets[$bridge] = $bridgeIds;
            }

            $jobs = $this->ownedContentIds('job_vacancies', $sets);
            $trainings = $this->ownedContentIds('trainings', $sets);
            $this->assertNoAlternateOwner('job_vacancies', $jobs, $sets);
            $this->assertNoAlternateOwner('trainings', $trainings, $sets);
            $jobApplications = $this->workerRows('job_applications', $sets);
            $trainingApplications = $this->workerRows('training_applications', $sets);
            $bookmarks = $this->workerRows('job_bookmarks', $sets);
            $this->assertNoCrossWorkerRows('job_applications', $jobApplications, $sets);
            $this->assertNoCrossWorkerRows('training_applications', $trainingApplications, $sets);
            $this->assertNoCrossWorkerRows('job_bookmarks', $bookmarks, $sets);

            if ($jobs) DB::table('job_vacancies')->whereIn('id', $jobs)->lockForUpdate()->get(['id']);
            if ($trainings) DB::table('trainings')->whereIn('id', $trainings)->lockForUpdate()->get(['id']);

            $sets['users'] = [$locked->id];
            $sets['job_vacancies'] = $jobs;
            $sets['trainings'] = $trainings;
            $sets['user_order_manuals'] = DB::table('user_order_manuals')->where('user_id', $locked->id)->lockForUpdate()->pluck('id')->all();
            $sets['security_certificates'] = $sets['securities'] ? DB::table('security_certificates')->whereIn('security_id', $sets['securities'])->pluck('id')->all() : [];
            $sets['cleaning_service_certificates'] = $sets['cleaning_services'] ? DB::table('cleaning_service_certificates')->whereIn('cleaning_service_id', $sets['cleaning_services'])->pluck('id')->all() : [];

            $targets = [];
            $this->collect($targets, 'users', ['avatar' => 'public_asset'], [$locked->id]);
            $this->collect($targets, 'securities', ['formal_photo' => 'public_asset'], $sets['securities']);
            $this->collect($targets, 'cleaning_services', ['formal_photo' => 'public_asset'], $sets['cleaning_services']);
            $this->collect($targets, 'security_certificates', ['file' => 'certificate'], $sets['security_certificates']);
            $this->collect($targets, 'cleaning_service_certificates', ['file' => 'certificate'], $sets['cleaning_service_certificates']);
            $this->collect($targets, 'companies', ['logo' => 'public_asset'], $sets['companies']);
            $this->collect($targets, 'b_u_j_p_s', ['logo' => 'public_asset', 'sio_file' => 'public_asset'], $sets['b_u_j_p_s']);
            $this->collect($targets, 'user_b_u_j_p_s', ['sio_file' => 'public_asset', 'sio_url' => 'public_asset'], $sets['user_b_u_j_p_s']);
            $this->collect($targets, 'trainings', ['poster' => 'public_asset'], $trainings);
            $this->collect($targets, 'user_order_manuals', ['file' => 'payment'], $sets['user_order_manuals']);
            $this->assertNoSharedFiles($targets, $sets);

            $manifest = [];
            foreach ($targets as $target) {
                $manifest[] = DB::table('account_deletion_files')->insertGetId($target + ['created_at' => now(), 'updated_at' => now()]);
            }

            foreach (['job_applications' => $jobApplications, 'training_applications' => $trainingApplications, 'job_bookmarks' => $bookmarks] as $table => $rows) {
                if ($rows) DB::table($table)->whereIn('id', $rows)->delete();
            }
            if ($jobs) DB::table('job_vacancies')->whereIn('id', $jobs)->delete();
            if ($trainings) DB::table('trainings')->whereIn('id', $trainings)->delete();
            DB::table(config('session.table', 'sessions'))->where('user_id', $locked->id)->delete();
            DB::table('password_reset_tokens')->where('email', $locked->email)->delete();
            $locked->delete();
            return $manifest;
        });

        return $this->files->purge($ids);
    }

    private function collect(array &$out, string $table, array $fields, array $ids, string $foreign = 'id'): void
    {
        if (! $ids) return;
        foreach (DB::table($table)->select(array_merge([$foreign], array_keys($fields)))->whereIn($foreign, $ids)->get() as $row) {
            foreach ($fields as $field => $kind) {
                if ($row->{$field} === null || $row->{$field} === '') continue;
                $normalized = $this->files->normalize((string) $row->{$field}, $kind);
                if ($normalized) $out[$normalized['location'].'|'.$normalized['path']] = $normalized;
            }
        }
    }


    private function ownedContentIds(string $table, array $sets): array
    {
        $query = DB::table($table);
        $hasOwner = false;
        if ($sets['companies']) { $query->whereIn('company_id', $sets['companies']); $hasOwner = true; }
        if ($sets['b_u_j_p_s']) {
            if ($hasOwner) $query->orWhereIn('b_u_j_p_id', $sets['b_u_j_p_s']);
            else $query->whereIn('b_u_j_p_id', $sets['b_u_j_p_s']);
            $hasOwner = true;
        }
        return $hasOwner ? $query->lockForUpdate()->pluck('id')->all() : [];
    }

    private function workerRows(string $table, array $sets): array
    {
        if (! $sets['securities'] && ! $sets['cleaning_services']) return [];
        return DB::table($table)->where(function ($query) use ($sets) {
            if ($sets['securities']) $query->whereIn('security_id', $sets['securities']);
            if ($sets['cleaning_services']) $query->orWhereIn('cleaning_service_id', $sets['cleaning_services']);
        })->lockForUpdate()->pluck('id')->all();
    }

    private function assertNoCrossWorkerRows(string $table, array $ids, array $sets): void
    {
        if (! $ids) return;
        foreach (DB::table($table)->whereIn('id', $ids)->get(['security_id', 'cleaning_service_id']) as $row) {
            if ($row->security_id && ! in_array($row->security_id, $sets['securities'], false)) $this->conflict();
            if ($row->cleaning_service_id && ! in_array($row->cleaning_service_id, $sets['cleaning_services'], false)) $this->conflict();
        }
    }

    private function assertNoAlternateOwner(string $table, array $ids, array $sets): void
    {
        if (! $ids) return;
        foreach (DB::table($table)->whereIn('id', $ids)->get(['company_id', 'b_u_j_p_id']) as $row) {
            if (($row->company_id && ! in_array($row->company_id, $sets['companies'], false)) || ($row->b_u_j_p_id && ! in_array($row->b_u_j_p_id, $sets['b_u_j_p_s'], false))) $this->conflict();
        }
    }

    private function assertNoSharedFiles(array $targets, array $sets): void
    {
        foreach ($targets as $target) $this->files->assertUnreferenced($target['location'], $target['path'], $sets);
    }

    private function conflict(): never
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => 'Akun tidak dapat dihapus karena ada data atau berkas yang dipakai bersama akun lain.'], 409));
    }
}
