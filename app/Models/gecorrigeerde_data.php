<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class gecorrigeerde_data extends Model
{
    use HasFactory;

    public $timestamps = false;
    public $incrementing = false;
    public $table = 'gecorrigeerde_data';

    protected $attributes = [
        'originele_data_id',
        'gecorrigeerde_data_id'
    ];

}
