<?php
/**
 * Created by PhpStorm.
 * User: ym-jenish
 * Date: 5/13/16
 * Time: 2:59 PM
 */

namespace App\Repository;


use App\Models\EmergencyFee;

class EmergencyFeeRepo
{
    /**
     * @var emergencyFee
     */
    private $emergencyFee;

    public function __construct(EmergencyFee $emergencyFee)
    {

        $this->emergencyFee = $emergencyFee;
    }

    public function all()
    {
        return $this->emergencyFee
            ->orderBy('id', 'DESC');
    }

    public function lists()
    {
        return $this->emergencyFee
            ->select('emergency_fee', 'id')
            ->orderBy('id', 'dsc')
            ->get();
    }

    public function currentemergencyFee()
    {
        return $this->emergencyFee
            ->where('current_emergency_fee', 'Y')
            ->first();
    }

    public function status($id)
    {
        $result = $this->emergencyFee
            ->where('id', $id)
            ->update(['current_emergency_fee'=> 'Y']);
        if($result) {
            return $this->emergencyFee
                ->where('id', '<>', $id)
                ->update(['current_emergency_fee' =>  'N']);
        }
        return $result;
    }
}