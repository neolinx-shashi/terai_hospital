<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientReferrer extends Model
{
    protected $table='patientReferrer';

    protected $fillable = [
        'institute_name',
        'institute_address',
        'medic_name',
        'medic_designation',
        'refer_reason',
        'entry_date',
        'release_date',
        'transferLetter_name',
        'labDocument_name',
        'radioDetail_name',
        'surgeryDetail_name',
        'previous_detections',
        'patient_history',
        'prescriptions',
        'discharge_summary',
        'iPatient_id',
        'status',
        'user_id'
    ];
}
