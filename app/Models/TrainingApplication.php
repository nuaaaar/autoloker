<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class TrainingApplication extends Model
{
    protected $guarded = ['id'];

    public function security()
    {
        return $this->belongsTo('App\Models\Security');
    }

    public function training()
    {
        return $this->belongsTo('App\Models\Training');
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
