<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class nearestlocation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $attributes = [
        'id',
        'station_name',
        'name',
        'administrative_region1',
        'administrative_region2',
        'country_code',
        'longitude',
        'latitude'
    ];
}
