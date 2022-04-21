<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class geolocation extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'id','station_id','country_code','island','county','place','hamlet','town','municipality','state_district','administrative','state','village','region','province','city','locality','postcode','country'

    ];
}
