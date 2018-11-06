<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DischargeDetail extends Model
{
    protected $fillable = [
        'ipatient_id',
        'room_id',
        'room_charge',
        'doctor_charge',
        'discount',
        'subtotal_after_discount',
        'total_after_tax',
        'hst',
        'user_id',
        'bill_number',
        'returned_amount',
        'received_amount'
    ];

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function isOfPatient()
    {
        return $this->belongsTo('App\Models\IPatient', 'ipatient_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function hasManyItems()
    {
        return $this->hasMany('App\Models\DischargeInvoiceItem', 'id');
    }
}
