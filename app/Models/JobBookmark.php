<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class JobBookmark extends Model
{
    protected $guarded = ['id'];

    public function security()
    {
        return $this->belongsTo('App\Models\Security');
    }

    public function job_vacancy()
    {
        return $this->belongsTo('App\Models\JobVacancy');
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
