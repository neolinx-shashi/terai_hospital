<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorCharge extends Model
{
    protected $fillable = [
        'title',
        'charge'
    ];
}
