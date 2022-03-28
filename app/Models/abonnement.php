<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class abonnement extends Model
{
    use HasFactory;
    protected $primaryKey = 'user_id';
    public $incrementing = false;

    protected $attributes = [
        'user_id',
        'abonnement_id',
        'start_date',
        'end_date',
        'active',
        'last_update'
    ];

}
