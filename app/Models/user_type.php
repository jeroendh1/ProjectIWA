<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class user_type extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'type_id';

    protected $attributes = [
        'type_id',
        'naam'
    ];
}
