<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;

    public $incrementing = false;
    public $timestamps = false;
    protected $table = 'weatherData';
    protected $fillable = true;

    protected $attributes = [
        'STN',
        'DATE',
        'TIME',
        'TEMP',
        'DEWP',
        'STP',
        'SLP',
        'VISIB',
        'WDSP',
        'PRCP',
        'SNDP',
        'FRSHTT',
        'CLDC',
        'WNDDIR'
    ];
}
