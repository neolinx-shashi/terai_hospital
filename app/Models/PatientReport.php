<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientReport extends Model
{
    protected $table = 'patientReport';

    protected $fillable = [
        'report_number',
        'ipatient_code',
        'ipatient_id',
        'doctor_id',
        'doctor_report',
        'user_id'
    ];

    public function isOfPatient()
    {
        return $this->belongsTo('App\Models\IPatient', 'ipatient_id');
    }
    public function isOfDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }
}
