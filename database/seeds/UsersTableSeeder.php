<?php

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users =
            [
                [
                    'fullname'=>'Admin Neolinx',
                    'email'=>'hospitaladmin',
                    'contact_no'=>'01-4781149',
                    'gender'=>'Others',
                    'address'=>'Buddhanagar',
                    'user_post'=>'SuperAdmin',
                    'password'=>bcrypt('admin'),
                    'status'=>'Active',
                    'userimage_name'=>'notimage',
                    'ip_address'=>'192.168.0.1',
                    'browser_agent'=>'mozilla',
                    'user_type_id'=>'1'
                ],

                [
                    
                    'fullname'=>'Terai Hospital',
                    'email'=>'hospital@admin.com',
                    'contact_no'=>'01-4781149',
                    'gender'=>'Others',
                    'address'=>'Buddhanagar',
                    'user_post'=>'SuperAdmin',
                    'password'=>bcrypt('admin'),
                    'status'=>'Active',
                    'userimage_name'=>'notimage',
                    'ip_address'=>'192.168.0.1',
                    'browser_agent'=>'mozilla',
                    'user_type_id'=>'2'
                ],


                [
                    
                    'fullname'=>'Billing Hospital',
                    'email'=>'hospitalbilling',
                    'contact_no'=>'01-4781149',
                    'gender'=>'Others',
                    'address'=>'Buddhanagar',
                    'user_post'=>'SuperAdmin',
                    'password'=>bcrypt('admin'),
                    'status'=>'Active',
                    'userimage_name'=>'notimage',
                    'ip_address'=>'192.168.0.1',
                    'browser_agent'=>'mozilla',
                    'user_type_id'=>'3'
                ],

                [
                    
                    'fullname'=>'Account Hospital',
                    'email'=>'hospitalaccount',
                    'contact_no'=>'01-4781149',
                    'gender'=>'Others',
                    'address'=>'Buddhanagar',
                    'user_post'=>'SuperAdmin',
                    'password'=>bcrypt('admin'),
                    'status'=>'Active',
                    'userimage_name'=>'notimage',
                    'ip_address'=>'192.168.0.1',
                    'browser_agent'=>'mozilla',
                    'user_type_id'=>'4'
                ],

               
            ];
         User::truncate();
         User::insert($users);



    }
}
