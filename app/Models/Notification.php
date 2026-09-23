<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Notification extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];


    /**
     * User penerima notification.
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id'
        );
    }


    /**
     * Master notification.
     */
    public function master()
    {
        return $this->belongsTo(
            MasterNotification::class,
            'notification_id'
        );
    }


    /**
     * Generate UUID.
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (empty($model->uuid)) {

                $model->uuid = (string) Str::uuid();
            }

        });
    }
}