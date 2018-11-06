<?php
/**
 * Created by PhpStorm.
 * User:purna
 * Date: 5/13/16
 * Time: 2:59 PM
 */

namespace App\Repository;


use App\Models\Ward;
use App\Models\Bed;
use App\Models\Room;
use App\Models\Contact;
use App\Models\Category;
use App\Models\User;
use App\Models\LoginLogs;
class DashboardRepo
{
    /**
     * @var emergencyFee
     */
    private $ward;
    private $room;
    private $bed;
    private $contact;
    private $category;
    private $user;
    private $loginLogs;

    public function __construct(Ward $ward,
                                Room $room,
                                Bed $bed,
                                Contact $contact,
                                Category $category,
                                User $user,
                                LoginLogs $loginLogs)
                {
                        $this->ward=$ward;
                        $this->bed=$bed;
                        $this->room=$room;
                        $this->contact=$contact;
                        $this->category=$category;
                        $this->user=$user;
                        $this->loginLogs=$loginLogs;
                }

                public function getWardDetails()
                {
                    $ward=$this->ward
                    ->get();
                    return $ward;

                }

                public function roomDetails()
                {
                    $room=$this->room->get();
                    return $room;
                }

                public function bedDetails()
                {
                    $bed=$this->bed->get();
                    return $bed;
                }

                public function getTotalContact()
                {
                    $contacts=$this->contact
                    ->orderBy('created_at','DSC')
                    ->get();
                    return $contacts;
                }

                public function getAllTests()
                {

                     $tests=$this->category
                     ->where('level',3)
                    ->orderBy('created_at','DSC')
                    ->get();
                    return $tests;
                }

                public function getallUsers()
                {
                    $users=$this->user
                    ->where('user_type_id','!=',1)
                    ->orderBy('id','dsc')
                    ->paginate(10);

                    return $users;
                }

                public function getUserHistory()
                {
                    $loginLogs=$this->loginLogs
                    ->orderBy('created_at','dsc')
                    ->get();

                    return $loginLogs;
                }
}