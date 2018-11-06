<?php

/**
 * Created by PhpStorm.
 * User: Surya
 * Date: 2/12/2016
 * Time: 10:39 PM
 */
namespace App\Repository\UsersRepo;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class UsersRepository
{
    /**
     * @var User
     */
    private $user;

    public function __construct(User $user)
    {

        $this->user = $user;
    }

    public function getUserDetailsOfId()
    {
        $userId=Auth::user()->user_type_id;
        $id=Auth::user()->id;

        if($userId=='1')
        {
            return $this->user
            ->orderBy('created_at', 'dsc');
              
        }

        elseif($userId=='2')
        {
            return $this->user
            ->where('user_type_id','!=','1')
            ->orderBy('created_at', 'asc');
        }

         elseif($userId=='5')
        {
            return $this->user
            ->where('user_type_id','!=','1')
            ->where('user_type_id','!=','2')
            ->orderBy('created_at', 'dsc');
        }


        else
        {
            return $this->user
            ->where('user_type_id',$userId)
            ->where('id',$id)
            ->orderBy('created_at', 'dsc');
            
        }


      
    }

    public function listsLogUser()
    {
        $id = Auth::user()->id;
        return $this->user
            ->where('id', $id)
            ->first();
    }
}