<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FiscalYear extends Model
{
     protected $table='fiscal_year';
    protected $fillable = [

        'fiscal_year_nepali',
        'current_fiscal_year',
        'fiscal_year_start_date',
        'fiscal_year_end_date'


    ];
    public $timestamps = false;

}