<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'user_id';
    //CONST CREATED_AT = 'regDate';
    protected $table = 'userdata';


    protected $attributes = [
        'user_id',
        'first_name',
        'last_name',
        'email',
        'regDate',
        'city',
        'last_login'
    ];
}
