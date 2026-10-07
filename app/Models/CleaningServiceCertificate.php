<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class CleaningServiceCertificate extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function certificates()
    {
        return $this->hasMany(
            CleaningServiceCertificate::class,
            'cleaning_service_id'
        );
    }

    public function badgeCertificate()
    {
        return $this->hasMany(
            CleaningServiceCertificate::class,
            'cleaning_service_id'
        )->where('is_badge', 1);
    }

    public function histories()
    {
        return $this->hasMany(
            CleaningServiceHistory::class,
            'cleaning_service_id'
        );
    }

    public function cleaningService() { return $this->belongsTo( CleaningService::class, 'cleaning_service_id' ); }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
