<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DischargeInvoiceItem extends Model
{
    protected $fillable=[
        'discharge_id',
        'test_id',
        'test_price',
        'quantity',
    ];

    public function isOfDischargeDetail()
    {
        return $this->belongsTo('App\Models\DischargeDetail', 'discharge_id');
    }
}
