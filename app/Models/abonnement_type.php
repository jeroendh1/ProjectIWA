<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement_type extends Model
{
    use HasFactory;

    protected $primaryKey = 'abonnement_id';
    public $timestamps = false;
    /*
    * 
    * Table Attributes
    *
    * @var array
    * 
    */
   protected $attributes = [
       'abonnement_id',
       'naam'
   ];
}