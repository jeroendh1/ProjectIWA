<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class country extends Model
{
    use HasFactory;
    /**
     * The table associated with the model
     * 
     * @var string
     */
    protected $table = 'countries';

    // primary key
    protected $primaryKey = 'country_id';
    
    
    // model ID is not auto-incrementing.
    public $incrementing = false;
    public $timestamps = false;
    /**
     * 
     * Table Attributes
     *
     * @var array 
     * 
     */
    protected $attributes = [
        'country_id',
        'country_code',
        'country'
    ];

}
