<?php

namespace App\Repository\UsersRepo;

use App\Models\UsersType;
use Illuminate\Support\Facades\Auth;

class UsersTypeRepository
{
    /**
     * @var User
     */
    private $userType;

    public function __construct(UsersType $userType)
    {

        $this->userType = $userType;
    }

    public function all()
    {
        return $this->userType
            ->get();
    }

    public function isSuperAdmin()
    {
        $userId=Auth::user()->user_type_id;

        if($userId == '1')
        {
            return $this->userType
            ->where('id','!=','1')
            ->get(); 
        }



        elseif($userId == '2')
        {
          return $this->userType
            ->where('id','!=','1')
            ->where('id','!=','2')
            ->get();  
        }

        elseif($userId == '5')
        {
          return $this->userType
            ->where('id','!=','1')
            ->where('id','!=','2')
            ->where('id','!=','5')
            ->get();  
        }
    }
   
}