<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class MasterNotification extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'web_enabled'    => 'boolean',
        'mobile_enabled' => 'boolean',
        'email_enabled'  => 'boolean',
        'push_enabled'   => 'boolean',
        'is_active'      => 'boolean',
    ];

    /**
     * Notification yang menggunakan master ini.
     */
    public function notifications()
    {
        return $this->hasMany(
            Notification::class,
            'notification_id'
        );
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            if (!$model->uuid) {
                $model->uuid = (string) Str::uuid();
            }

        });
    }
}