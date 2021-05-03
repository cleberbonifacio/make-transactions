<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Wallets extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_user',
        'amount'
    ];

    public function user()
    {
        return $this->hasOne(User::class , 'id');
    }
}
