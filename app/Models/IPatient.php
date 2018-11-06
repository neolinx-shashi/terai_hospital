<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IPatient extends Model
{
    protected $table='ipatient';

    protected $fillable = [
        'first_name',
        'middle_name',
        'last_name',
        'patient_dob',
        'age',
        'gender',
        'bloodGroup_id',
        'permanent_address',
        'temporary_address',
        'phone',
        'nationality_id',
        'marital_status',
        'spouse_name',
        'deposit_amount',
        'patientGuardian_id',
        'patientReferrer_id',
        'ward_id',
        'room_id',
        'room_type',
        'bed_id',
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
        'status',
        'patient_code',
        'patient_type',
        'doctor_id',
        'department_id',
        'doctor_note',
        'user_id',
        'discharge_note',
        'discharged_at',
        'fiscal_year_id',
        'description',
        'refund_user_id',
        'bill_number',
        'admission_charge',
        'admission_charge_hst',
        'admission_charge_with_tax',
        'diagnosis',
        'treatment',
        'follow_up',
        'deposit_dates',
        'deposit_times',
        'deposit_user_id',
        'discharge_user_id'
    ];

    public function isOfNationality()
    {
        return $this->belongsTo('App\Models\Nationality', 'nationality_id');
    }

    public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }

    public function belongsToUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function isConsultedToDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function getCurrentFiscalYear()
    {
        return $this->belongsTo('App\Models\FiscalYear', 'fiscal_year_id');
    }

    public function hasBillingDetail()
    {
        return $this->hasMany('App\Models\Billing', 'id');
    }

    public function hasTestDetail()
    {
        return $this->hasMany('App\Models\TestDetail', 'id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */

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

    public function getDischargeDetail()
    {
        return $this->hasOne('App\Models\DischargeDetail', 'ipatient_id');
    }

    public function getEmrDischargeDetail()
    {
        return $this->hasOne('App\Models\Billing', 'patient_id');
    }
}
