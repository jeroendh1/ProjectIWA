<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_login extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $attributes = [
        'username',
        'password'
    ];
}
