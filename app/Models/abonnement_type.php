<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement_type extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $primaryKey = 'abonnement_id';

    public function abonnement(){
        return $this->hasMany(abonnement::class);
    }
}
