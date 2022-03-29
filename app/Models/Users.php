<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;
    public $timestamps = false;

    //CONST CREATED_AT = 'regDate';
    protected $table = 'users';


//    protected $attributes = [
//        'username',
//        'password',
//        'user_id',
//        'first_name',
//        'last_name',
//        'email',
//        'regDate',
//        'city',
//        'last_login'
//    ];

    public function userType(){
        return $this->belongsTo(user_type::class);
    }
}
