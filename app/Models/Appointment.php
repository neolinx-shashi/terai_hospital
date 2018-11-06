<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $table = 'reservation';
    
    protected $primaryKey = 'res_id';
    
    protected $fillable = ['res_doc_id',
							'res_shift_id',
							'patient_contact',
							'patient_name',
							'res_date'];
}
