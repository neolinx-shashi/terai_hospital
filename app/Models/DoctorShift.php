<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorShift extends Model
{
    protected $table = 'tbl_shift';
    protected $fillable = [
        'day_id',
        'start_time',
        'end_time',
        'shift_type',
        'status',
       
    ];

   public function isInDepartment()
    {
        return $this->belongsTo('App\Models\Department', 'department_id');
    }
}
