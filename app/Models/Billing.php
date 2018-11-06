<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    protected $fillable = [
        'patient_id',
        'doctor_id',
        'consulting_doctor_id',
        'date',
        'sub_total',
        'tax',
        'discount',
        'grand_total',
        'user_id',
        'status',
        'patient_type',
        'consulting_doctor_rate',
        'refund_user_id',
        'refund_remark',
        'bill_number'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToPatient()
    {
        return $this->belongsTo('App\Models\Patient', 'patient_id');
    }

    public function belongsToEmrPatient()
    {
        return $this->belongsTo('App\Models\IPatient', 'patient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function belongsToUser()
    {
        return $this->belongsTo('App\Models\User', 'user_id');
    }

    public function referredByDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    public function consultedToDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'consulting_doctor_id');
    }

    public function isOfTest()
    {
        return $this->hasOne('App\Models\TestDetail', 'bid');
    }

    public function isOfDoctor()
    {
        return $this->belongsTo('App\Models\Doctor', 'doctor_id');
    }

    //  public function isOfWard()
    // {
    //     return $this->belongsTo('App\Models\Ward', 'ward_id');
    // }

    // public function isOfRoom()
    // {
    //     return $this->belongsTo('App\Models\Room', 'room_id');
    // }

    // public function isOfBed()
    // {
    //     return $this->belongsTo('App\Models\Bed', 'bed_id');
    // }

    protected $table = 'billing_detail';

    protected $primaryKey = 'bid';
}
