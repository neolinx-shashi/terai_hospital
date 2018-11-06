<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPDAdmissionCharge extends Model
{
    protected $fillable = [
        'admission_charge',
        'current_admission_charge'
    ];
}
