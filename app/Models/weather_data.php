<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class weather_data extends Model
{
    use HasFactory;

    protected $primaryKey = 'data_id';
    public $timestamps = false;
    protected $table = 'weather_data';

    protected $attributes = [
        'data_id',
        'station_id',
        'date',
        'time',
        'temperatuur',
        'dauwpunt_temperatuur',
        'station_luchtdruk',
        'zeeniveau_luchtdruk',
        'zicht',
        'windsnelheid',
        'neerslag',
        'sneeuwdiepte',
        'vorst_regen_sneeuw_hagel_onweer_tornado',
        'bewolking',
        'windrichting'
    ];
}
