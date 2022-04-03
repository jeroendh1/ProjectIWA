<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class station extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'stn_name';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $attributes = [
        'stn_name',
        'longitude',
        'latitude',
        'elevation'
    ];

}
