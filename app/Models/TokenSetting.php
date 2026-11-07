<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenSetting extends Model
{
    protected $table = 'token_settings';

    protected $guarded = ['id'];

    protected function casts(): array
    {
        return [
            'idr_per_token' => 'integer',
            'job_post_tokens' => 'integer',
            'job_post_days' => 'integer',
            'training_post_tokens' => 'integer',
            'training_post_days' => 'integer',
        ];
    }

    public static function current(): self
    {
        return static::query()->firstOrCreate(
            ['id' => 1],
            [
                'idr_per_token' => 10000,
                'job_post_tokens' => 4,
                'job_post_days' => 14,
                'training_post_tokens' => 4,
                'training_post_days' => 30,
            ]
        );
    }
}
