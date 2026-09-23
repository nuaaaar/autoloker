<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class UserOrderManual extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'price' => 'decimal:2',
        'payment_date' => 'datetime',
        'verified_at' => 'datetime',
        'expired_at' => 'datetime',
    ];


    /*
    |--------------------------------------------------------------------------
    | BOOTED
    |--------------------------------------------------------------------------
    */

    protected static function booted(): void
    {
        static::creating(function (UserOrderManual $order) {

            if (!$order->uuid) {
                $order->uuid = (string) Str::uuid();
            }

        });
    }


    /*
    |--------------------------------------------------------------------------
    | USER
    |--------------------------------------------------------------------------
    */

    public function user(): BelongsTo
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /*
    |--------------------------------------------------------------------------
    | SUBSCRIPTION
    |--------------------------------------------------------------------------
    */

    public function subscription(): BelongsTo
    {
        return $this->belongsTo(
            MasterSubscription::class,
            'master_subscription_id'
        );
    }

    public function userSubscription()
    {
        return $this->hasOne(
            UserSubscription::class,
            'user_order_manual_id'
        );
    }
}