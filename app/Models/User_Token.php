<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class User_Token extends Model
{
    protected $table = 'users_token';
    protected $primaryKey = 'id';
}
