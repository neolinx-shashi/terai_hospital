<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPatientHistory extends Model
{
    protected $fillable = [
        'ipatient_id',
        'doctor_id',
        'charge_id',
        'doctor_fee',
        'appointment',
        'description'
    ];

    public function isOfPatient()
    {
        return $this->belongsTo('App\Models\IPatient', 'ipatient_id');
    }
}
