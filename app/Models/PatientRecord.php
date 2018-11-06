<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientRecord extends Model
{
	 protected $table = 'patient_records';
    protected $fillable = [
        'patient_id',
        'fee',
    ];

    /*public function isOfPatient()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }*/
}
