<?php

namespace App\Services;

use App\Models\JobVacancy;
use App\Models\TokenSetting;
use App\Models\TokenTransaction;
use App\Models\TokenWallet;
use App\Models\Training;
use App\Models\User;
use App\Models\UserOrderManual;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class TokenBillingService
{
    public function ownerFor(User $user): array
    {
        if ($user->role === 'company' && ($company = $user->user_company?->company)) {
            return ['column' => 'company_id', 'id' => (int) $company->id];
        }

        if ($user->role === 'bujp' && ($bujp = $user->user_bujp?->bujp)) {
            return ['column' => 'b_u_j_p_id', 'id' => (int) $bujp->id];
        }

        throw new AuthorizationException('Hanya organisasi pemberi kerja yang dapat menggunakan token.');
    }

    public function walletFor(array $owner): TokenWallet
    {
        abort_unless(
            in_array($owner['column'] ?? null, ['company_id', 'b_u_j_p_id'], true)
                && (int) ($owner['id'] ?? 0) > 0,
            403
        );

        $type = $owner['column'] === 'company_id' ? 'company' : 'bujp';

        return TokenWallet::firstOrCreate(
            ['owner_type' => $type, 'owner_id' => (int) $owner['id']],
            ['balance' => 0]
        );
    }

    public function creditOrder(UserOrderManual $order): TokenWallet
    {
        return DB::transaction(function () use ($order) {
            $order = UserOrderManual::whereKey($order->id)->lockForUpdate()->firstOrFail();

            if ($order->status === 'approved' && $order->token_wallet_id) {
                return TokenWallet::whereKey($order->token_wallet_id)->lockForUpdate()->firstOrFail();
            }

            if (
                $order->master_subscription_id !== null
                || $order->status !== 'verification'
                || ($order->expired_at !== null && ! $order->expired_at->isFuture())
                || ! $order->token_quantity
                || ! $order->idr_per_token
            ) {
                throw ValidationException::withMessages([
                    'order' => 'Pesanan token tidak memenuhi syarat persetujuan.',
                ]);
            }

            $wallet = TokenWallet::whereKey($order->token_wallet_id)->lockForUpdate()->firstOrFail();
            $eventKey = 'order:'.$order->id;

            if (! TokenTransaction::where('event_key', $eventKey)->exists()) {
                if ((int) $order->token_quantity > PHP_INT_MAX - $wallet->balance) {
                    throw ValidationException::withMessages([
                        'order' => 'Jumlah token melebihi batas saldo yang dapat disimpan.',
                    ]);
                }

                $wallet->balance += (int) $order->token_quantity;
                $wallet->save();

                TokenTransaction::create([
                    'token_wallet_id' => $wallet->id,
                    'amount' => (int) $order->token_quantity,
                    'balance_after' => $wallet->balance,
                    'kind' => 'topup',
                    'event_key' => $eventKey,
                    'subject_type' => UserOrderManual::class,
                    'subject_id' => $order->id,
                ]);
            }

            $order->forceFill([
                'status' => 'approved',
                'verified_at' => $order->verified_at ?? now(),
            ])->save();

            return $wallet;
        });
    }

    public function publish(JobVacancy|Training $post): JobVacancy|Training
    {
        return DB::transaction(function () use ($post) {
            $model = $post instanceof Training ? Training::class : JobVacancy::class;
            $post = $model::whereKey($post->id)->lockForUpdate()->firstOrFail();

            if ($post->isCurrentlyPublished()) {
                return $post;
            }

            if (
                $post instanceof Training
                && (
                    in_array($post->status, ['closed', 'running', 'cancelled'], true)
                    || ($post->start_date && now()->startOfDay()->gte($post->start_date))
                )
            ) {
                throw ValidationException::withMessages([
                    'publication' => 'Pelatihan yang sudah ditutup, dimulai, atau dibatalkan tidak dapat dipublikasikan ulang.',
                ]);
            }

            if (! in_array($post->status, ['draft', 'rejected', 'closed', 'expired', 'published'], true)) {
                throw ValidationException::withMessages([
                    'publication' => 'Postingan tidak dapat dipublikasikan dari status saat ini.',
                ]);
            }

            if ($post->company_id && $post->b_u_j_p_id) {
                throw ValidationException::withMessages([
                    'publication' => 'Postingan memiliki lebih dari satu organisasi pemilik.',
                ]);
            }

            $ownerColumn = $post->company_id ? 'company_id' : 'b_u_j_p_id';
            $ownerId = $post->{$ownerColumn};
            if (! $ownerId) {
                throw ValidationException::withMessages([
                    'publication' => 'Postingan tidak memiliki organisasi pemilik.',
                ]);
            }

            $wallet = $this->walletFor([
                'column' => $ownerColumn,
                'id' => (int) $ownerId,
            ]);
            $wallet = TokenWallet::whereKey($wallet->id)->lockForUpdate()->firstOrFail();
            $settings = TokenSetting::current();
            $kind = $post instanceof Training ? 'training' : 'job';
            $cost = (int) $settings->{$kind.'_post_tokens'};

            if ($wallet->balance < $cost) {
                throw ValidationException::withMessages([
                    'balance' => 'Saldo token tidak mencukupi.',
                ]);
            }

            $cycle = (int) $post->publication_cycle + 1;
            $wallet->balance -= $cost;
            $wallet->save();

            TokenTransaction::create([
                'token_wallet_id' => $wallet->id,
                'amount' => -$cost,
                'balance_after' => $wallet->balance,
                'kind' => $kind.'_publication',
                'event_key' => strtolower(class_basename($post)).':'.$post->id.':publication:'.$cycle,
                'subject_type' => $model,
                'subject_id' => $post->id,
            ]);

            $publishedAt = now();
            $post->forceFill([
                'status' => 'published',
                'published_at' => $publishedAt,
                'publication_expires_at' => $publishedAt->copy()->addSeconds((int) $settings->{$kind.'_post_days'} * 86400),
                'publication_token_cost' => $cost,
                'publication_cycle' => $cycle,
            ])->save();

            return $post;
        });
    }

    public function assertEditable(JobVacancy|Training $post): void
    {
        if ($post->isCurrentlyPublished()) {
            throw ValidationException::withMessages([
                'post' => 'Postingan yang masih aktif tidak dapat diedit.',
            ]);
        }
    }
}
