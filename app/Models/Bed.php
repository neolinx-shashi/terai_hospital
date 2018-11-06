<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Bed extends Model
{
    protected $table = 'bed';

    protected $fillable = [
        'bed_name',
        'ward_id',
        'room_id',
        'availability'
    ];

    public function isOfRoom()
    {
        return $this->belongsTo('App\Models\Room', 'room_id');
    }
    public function isOfWard()
    {
        return $this->belongsTo('App\Models\Ward', 'ward_id');
    }
    public function isOfPatient()
    {
        return $this->belongsTo('App\Models\IPatient', 'patient_id');
    }
}
