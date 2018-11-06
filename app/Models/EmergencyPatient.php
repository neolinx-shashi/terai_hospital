<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmergencyPatient extends Model
{
    protected $table = 'ipatient';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'age',
        'gender',
        'phone',
        'bloodGroup_id',
        'permanent_address',
        'nationality_id',
        'ward_id',
        'room_id',
        'bed_id',
        'doctor_id',
        'doctor_fee',
        'description',
        'department_id',
        'user_id',
        'discharge_note',
        'discharged_at',
        'fiscal_year_id',
        'patient_code',
        'patient_type',
        'status',
        'room_charge',
        'total_charge_after_tax',
        'doctor_tax_only',
        'doctor_fee_with_tax',
        'bill_number'
    ];


    

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function isOfNationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id');
    }

    public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function belongsToDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function belongsToUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function hasPatientGuardian()
    {
        return $this->belongsTo('App\Models\PatientGuardian', 'patientGuardian_id');
    }

    public function hasPatientReferrer()
    {
        return $this->belongsTo('App\Models\PatientReferrer', 'patientReferrer_id');
    }

    public function isOfWard()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id');
    }

    public function isOfRoom()
    {
        return $this->belongsTo('App\Models\Room', 'room_id');
    }

    public function isOfBed()
    {
        return $this->belongsTo('App\Models\Bed', 'bed_id');
    }

    public function hasHistory()
    {
        return $this->hasMany('App\Models\IPatientHistory', 'ipatient_id');
    }

    public function getCurrentFiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear', 'fiscal_year_id');
    }

    public function getDischargeDetail()
    {
        return $this->hasMany('App\Models\DischargeDetail', 'ipatient_id');
    }

    public function isConsultedToDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function hasBillingDetail()
    {
        return $this->hasMany('App\Models\Billing', 'id');
    }

    public function hasTestDetail()
    {
        return $this->hasMany('App\Models\TestDetail', 'id');
    }
}
