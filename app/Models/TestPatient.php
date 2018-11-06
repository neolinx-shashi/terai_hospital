<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestPatient extends Model
{
    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'permanent_address',
        'phone',
        'gender',
        'nationality_id',
        'department_id',
        'doctor_id',
        'doctor_fee',
        'appointment',
        'symptoms',
        'status ',
        'patient_code',
        'patient_type',
        'user_id',
        'fiscal_year_id',
    ];

    protected $table = 'ipatient';

    protected $primaryKey = 'id';
}
