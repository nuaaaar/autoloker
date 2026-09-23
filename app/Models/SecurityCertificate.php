<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SecurityCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function certificates()
    {
        return $this->hasMany(
            SecurityCertificate::class,
            'security_id'
        );
    }

    public function badgeCertificate()
    {
        return $this->hasMany(
            SecurityCertificate::class,
            'security_id'
        )->where('is_badge', 1);
    }

    public function histories()
    {
        return $this->hasMany(
            SecurityHistory::class,
            'security_id'
        );
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
