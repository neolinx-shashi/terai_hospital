<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Patient extends Model
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
        'status',
        'patient_code',
        'user_id',
        'doctor_fee_with_tax',
        'patient_type',
        'fiscal_year_id',
        'discount_percent',
        'discounted_fee_value',
        'doctor_tax_only',
        'refund_status',
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

    protected $table = 'ipatient';

}
