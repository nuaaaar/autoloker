<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TokenWallet extends Model
{
    protected $guarded = ['id'];

    protected function casts(): array
    {
        return ['balance' => 'integer'];
    }

    public function transactions()
    {
        return $this->hasMany(TokenTransaction::class);
    }

    public function orders()
    {
        return $this->hasMany(UserOrderManual::class);
    }
}
