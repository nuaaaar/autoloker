<?php

namespace App\Models\Concerns;

use Illuminate\Database\Eloquent\Builder;

trait HasTokenPublication
{
    protected function casts(): array
    {
        return array_merge(parent::casts(), [
            'published_at' => 'datetime',
            'publication_expires_at' => 'datetime',
            'publication_token_cost' => 'integer',
            'publication_cycle' => 'integer',
        ]);
    }

    public function scopeCurrentlyPublished(Builder $query): Builder
    {
        return $query
            ->where('status', 'published')
            ->where('publication_expires_at', '>', now());
    }

    public function isCurrentlyPublished(): bool
    {
        return $this->status === 'published'
            && $this->publication_expires_at !== null
            && $this->publication_expires_at->isFuture();
    }
}
