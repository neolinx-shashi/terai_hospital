<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyFee extends Model
{
    protected $table='emergency_fee';
    protected $fillable = [

        'emergency_fee',
        'current_emergency_fee'



    ];
    // public $timestamps = false;

}