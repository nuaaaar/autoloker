<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class UserBUJP extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    
    public function bujp()
    {
        return $this->hasOne('App\Models\BUJP');
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
