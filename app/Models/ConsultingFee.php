<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConsultingFee extends Model
{
    protected $table = 'consulting_fees';

    protected $fillable = ['normal_hours',
        'emergency_hours'
    ];

}
