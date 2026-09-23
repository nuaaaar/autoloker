<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MasterSubscription extends Model
{
    use SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'duration' => 'integer',
        'features' => 'array',
        'is_active' => 'boolean',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->uuid)) {
                $model->uuid = (string) Str::uuid();
            }
        });
    }

    /*
    |--------------------------------------------------------------------------
    | User Subscriptions
    |--------------------------------------------------------------------------
    */

    public function userSubscriptions()
    {
        return $this->hasMany(
            UserSubscription::class,
            'master_subscription_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | Manual Orders
    |--------------------------------------------------------------------------
    */

    public function userOrders()
    {
        return $this->hasMany(
            UserOrderManual::class,
            'master_subscription_id'
        );
    }
}