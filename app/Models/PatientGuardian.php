<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientGuardian extends Model
{
    protected $table='patientGuardian';

    protected $fillable = [
        'guardian_name',
        'guardian_relation',
        'guardian_phone',
        'guardian_address',
        'parent_name',
        'local_guardian',
        'parent_phone',
        'parent_email',
        'parent_address',
        'parent_occupation',
        'iPatient_id',
        'status',
        'user_id'
    ];

}
