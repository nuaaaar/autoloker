<?php

namespace App\Services\Api;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Exceptions\HttpResponseException;

class AccountDeletionFileService
{
    public function normalize(string $value, string $kind): ?array
    {
        if (! in_array($kind, ['public_asset', 'certificate', 'payment'], true)) $this->invalid();
        if ($value === '' || str_starts_with($value, 'assets/') || str_starts_with($value, '/assets/')) {
            return null;
        }

        $app = parse_url((string) config('app.url'));
        if (preg_match('#^https?://#i', $value)) {
            $url = parse_url($value);
            if (! $url || ! isset($url['scheme'], $url['host']) || ! in_array(strtolower($url['scheme']), ['http', 'https'], true)) $this->invalid();
            if (strtolower($url['scheme']) !== strtolower($app['scheme'] ?? '') || strtolower($url['host']) !== strtolower($app['host'] ?? '') || ($url['port'] ?? null) !== ($app['port'] ?? null)) return null;
            $value = $url['path'] ?? '';
        } elseif (str_contains($value, '://') || str_starts_with($value, '//')) {
            $this->invalid();
        }
        if (str_contains($value, "\0") || str_contains($value, '\\') || preg_match('/^[A-Za-z]:/', $value)) $this->invalid();
        if (str_starts_with($value, '/storage/')) $value = substr($value, 9);
        elseif (str_starts_with($value, '/uploads/')) $value = substr($value, 1);
        elseif (str_starts_with($value, '/')) $this->invalid();
        if (str_starts_with($value, 'storage/')) $value = substr($value, 8);
        if (str_starts_with($value, 'uploads/')) {
            if ($kind === 'certificate' && str_starts_with($value, 'uploads/certificate/')) return $this->validated('web_upload', $value, 'uploads/certificate/');
            if ($kind === 'payment' && str_starts_with($value, 'uploads/payment/')) return $this->validated('web_upload', $value, 'uploads/payment/');
            $this->invalid();
        }
        if ($kind === 'payment') {
            if (str_contains($value, '/')) $this->invalid();
            return $this->validated('web_upload', 'uploads/payment/'.$value, 'uploads/payment/');
        }
        $prefixes = $kind === 'certificate' ? ['certificate/'] : ['formal-photo/', 'company-logo/', 'sio-file/', 'training/posters/', 'trainings/posters/'];
        foreach ($prefixes as $prefix) {
            if (str_starts_with($value, $prefix)) return $this->validated('public_disk', $value, $prefix);
        }
        $this->invalid();
    }

    public function purge(array $ids): bool
    {
        $success = true;
        foreach (array_unique(array_map('intval', $ids)) as $id) {
            try {
                $done = DB::transaction(function () use ($id) {
                    $row = DB::table('account_deletion_files')->where('id', $id)->lockForUpdate()->first();
                    if (! $row) return true;
                    if (! in_array($row->location, ['public_disk', 'web_upload'], true)) return false;
                    $kind = $row->location === 'web_upload' ? (str_starts_with($row->path, 'uploads/payment/') ? 'payment' : 'certificate') : (str_starts_with($row->path, 'certificate/') ? 'certificate' : 'public_asset');
                    if ($this->normalize((string) $row->path, $kind) !== ['location' => $row->location, 'path' => $row->path]) return false;
                    if ($this->isReferenced($row->location, $row->path)) return false;
                    $absolute = $this->absolutePath($row->location, $row->path);
                    if ($absolute === null) return false;
                    if ($row->location === 'public_disk') {
                        $disk = Storage::disk('public');
                        if (! $disk->exists($row->path)) {
                            DB::table('account_deletion_files')->where('id', $id)->delete();
                            return true;
                        }
                        if (! $disk->delete($row->path) || $disk->exists($row->path)) return false;
                    } else {
                        if (! File::exists($absolute)) {
                            DB::table('account_deletion_files')->where('id', $id)->delete();
                            return true;
                        }
                        if (! File::delete($absolute) || File::exists($absolute)) return false;
                    }
                    DB::table('account_deletion_files')->where('id', $id)->delete();
                    return true;
                });
                $success = $success && $done;
            } catch (\Throwable) {
                $success = false;
            }
        }
        return $success;
    }

    private function validated(string $location, string $path, string $prefix): array
    {
        if (str_contains($path, "\0") || str_contains($path, '\\') || preg_match('#(^|/)\.\.?(/|$)#', $path) || ! str_starts_with($path, $prefix) || strlen($path) === strlen($prefix)) $this->invalid();
        $absolute = $this->absolutePath($location, $path);
        if ($absolute !== null && File::exists($absolute)) {
            $real = realpath($absolute);
            $root = realpath($this->root($location, $path));
            if (! $real || ! $root || ! str_starts_with($real, rtrim($root, DIRECTORY_SEPARATOR).DIRECTORY_SEPARATOR)) $this->invalid();
        }
        return ['location' => $location, 'path' => $path];
    }

    private function root(string $location, string $path): string
    {
        if ($location === 'public_disk') return Storage::disk('public')->path('');
        return public_path(str_starts_with($path, 'uploads/certificate/') ? 'uploads/certificate' : 'uploads/payment');
    }

    private function absolutePath(string $location, string $path): ?string
    {
        if ($location === 'public_disk') return Storage::disk('public')->path($path);
        if (str_starts_with($path, 'uploads/certificate/')) return public_path($path);
        if (str_starts_with($path, 'uploads/payment/')) return public_path($path);
        return null;
    }

    public function assertUnreferenced(string $location, string $path, array $ignored = []): void
    {
        if ($this->isReferenced($location, $path, $ignored)) {
            throw new HttpResponseException(response()->json(['status' => false, 'message' => 'Akun tidak dapat dihapus karena ada data atau berkas yang dipakai bersama akun lain.'], 409));
        }
    }

    private function isReferenced(string $location, string $path, array $ignored = []): bool
    {
        $fields = [
            'users' => ['avatar' => 'public_asset'], 'securities' => ['formal_photo' => 'public_asset'],
            'cleaning_services' => ['formal_photo' => 'public_asset'], 'security_certificates' => ['file' => 'certificate'],
            'cleaning_service_certificates' => ['file' => 'certificate'], 'companies' => ['logo' => 'public_asset'],
            'b_u_j_p_s' => ['logo' => 'public_asset', 'sio_file' => 'public_asset'], 'user_b_u_j_p_s' => ['sio_file' => 'public_asset', 'sio_url' => 'public_asset'],
            'trainings' => ['poster' => 'public_asset'], 'user_order_manuals' => ['file' => 'payment'], 'partners' => ['logo' => 'public_asset'],
        ];
        foreach ($fields as $table => $columns) {
            if (! \Illuminate\Support\Facades\Schema::hasTable($table)) continue;
            foreach ($columns as $column => $kind) {
                if (! \Illuminate\Support\Facades\Schema::hasColumn($table, $column)) continue;
                $query = DB::table($table)->select('id', $column)->whereNotNull($column);
                if (! empty($ignored[$table])) $query->whereNotIn('id', $ignored[$table]);
                $found = false;
                $query->orderBy('id')->lazyById(500)->each(function ($row) use ($column, $kind, $location, $path, &$found) {
                    try { $normalized = $this->normalize((string) $row->{$column}, $kind); } catch (\Throwable) { $normalized = null; }
                    if ($normalized === ['location' => $location, 'path' => $path]) $found = true;
                });
                if ($found) return true;
            }
        }
        return false;
    }

    private function invalid(): never
    {
        throw new HttpResponseException(response()->json(['status' => false, 'message' => 'Akun tidak dapat dihapus karena lokasi berkas tidak valid.'], 409));
    }
}
