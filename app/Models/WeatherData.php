<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WeatherData extends Model
{
    use HasFactory;
    protected $primaryKey = 'data_id';
    public $timestamps = false;
    protected $table = 'weatherdata';
}
