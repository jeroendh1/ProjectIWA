<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weather_data extends Model
{
    use HasFactory;

    protected $primaryKey = 'stn_name';
    protected $keyType = 'string';
    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'weather_data';

    protected $attributes = [
        'stn_name',
        'date',
        'time',
        'temp',
        'dewp',
        'stp',
        'slp',
        'visib',
        'wdsp',
        'prcp',
        'sndp',
        'frshtt',
        'cldc',
        'winddir'
    ];
}
