<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserTypes extends Model
{
    protected $table = "user_types";
    protected $primaryKey  = 'id';
    protected $fillable = [ 'id', 'types' ];
}
