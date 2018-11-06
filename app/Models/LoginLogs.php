<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;


class LoginLogs extends Model {


    protected $table='login_logs';

    protected $fillable = ['Intime',
  							  'login_date_time',
                            'logout_date_time',
                            'user_id'];

    


}