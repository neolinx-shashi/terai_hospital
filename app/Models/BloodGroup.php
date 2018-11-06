<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BloodGroup extends Model
{
    protected $table='bloodgroup';

    protected $fillable = [
        'blood_type',
        'rh_factor'
    ];
}
