<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountType extends Model
{
    protected $table = 'discount_type';

    protected $primaryKey = 'd_id';

    protected $fillable = ['d_type'];
}
