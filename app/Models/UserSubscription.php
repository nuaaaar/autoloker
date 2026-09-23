<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserSubscription extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'limits' => 'array',
        'started_at' => 'datetime',
        'expired_at' => 'datetime',
        'cancelled_at' => 'datetime',
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
    | USER
    |--------------------------------------------------------------------------
    */

    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | MASTER SUBSCRIPTION
    |--------------------------------------------------------------------------
    */

    public function subscription()
    {
        return $this->belongsTo(
            MasterSubscription::class,
            'master_subscription_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | ORDER
    |--------------------------------------------------------------------------
    */

    public function order()
    {
        return $this->belongsTo(
            UserOrderManual::class,
            'user_order_manual_id'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | SCOPE ACTIVE
    |--------------------------------------------------------------------------
    */

    public function scopeActive($query)
    {
        return $query
            ->where('status', 'active')
            ->whereNotNull('expired_at')
            ->where('expired_at', '>', now());
    }

    /*
    |--------------------------------------------------------------------------
    | CHECK ACTIVE
    |--------------------------------------------------------------------------
    */

    public function isActive()
    {
        return $this->status === 'active'
            && $this->expired_at
            && $this->expired_at->isFuture();
    }

    /*
    |--------------------------------------------------------------------------
    | REMAINING DAYS
    |--------------------------------------------------------------------------
    */

    public function remainingDays()
    {
        if (!$this->expired_at || $this->expired_at->isPast()) {
            return 0;
        }

        return now()->diffInDays(
            $this->expired_at
        );
    }
}