<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class MasterSubscription extends Model
{
    protected $table = 'master_subscriptions';

    protected $fillable = [
        'uuid',
        'name',
        'slug',
        'role',
        'price',
        'duration',
        'duration_type',
        'description',
        'features',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }

            if (
                empty($model->slug) &&
                !empty($model->name)
            ) {
                $model->slug = Str::slug($model->name);
            }
        });

        static::updating(function ($model) {

            if ($model->isDirty('name')) {
                $model->slug = Str::slug($model->name);
            }
        });
    }
}