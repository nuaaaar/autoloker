<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class ApiToken extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'access_expires_at' => 'datetime',
            'refresh_expires_at' => 'datetime',
            'last_used_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isAccessValid(): bool
    {
        return $this->revoked_at === null && $this->access_expires_at?->isFuture();
    }

    public function isRefreshValid(): bool
    {
        return $this->revoked_at === null && $this->refresh_expires_at?->isFuture();
    }
}
