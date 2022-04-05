<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    use HasFactory;
    protected $primaryKey = 'abonnement_id';
    public $timestamps = false;
//    protected $attributes = [
//        'abonnement_id',
//        'user_id',
//        'start_date',
//        'end_date',
//        'active',
//        'last_update'
//    ];
    public function AbonnementType(){
        return $this->belongsTo(abonnement_type::class);
    }

}
