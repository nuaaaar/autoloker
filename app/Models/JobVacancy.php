<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Concerns\HasTokenPublication;
use Illuminate\Support\Str;

class JobVacancy extends Model
{
    use HasTokenPublication;
    protected $guarded = ['id'];

    public function bujp()
    {
        return $this->belongsTo('App\Models\BUJP', 'b_u_j_p_id');
    }

    public function company()
    {
        return $this->belongsTo('App\Models\Company');
    }

    public function bookmarks()
    {
        return $this->hasMany(JobBookmark::class, 'job_vacancy_id');
    }

    public function applications()
    {
        return $this->hasMany(JobApplication::class,'job_vacancy_id');
    }

    public static function boot() {
        parent::boot();
    
        static::creating(function ($model) {
            $model->uuid = Str::uuid();
        });
    }
}
