<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class station extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $primaryKey = 'station_id';
    public $incrementing = false;

}
