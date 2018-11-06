<?php
use App\Models\UsersType;
use Illuminate\Database\Seeder;

class UsersTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userType =
            [
                [
                    'type_label' => 'Super Admin',
                    'type_name'=>'masterAdmin'
                ],

                [
                    'type_label' => 'Hospital Admin',
                    'type_name'=>'admin'
                ],

                [
                    'type_label' => 'Billing',
                    'current_fiscal_year'=>'billing'
                ],

                [
                    'type_label' => 'Account',
                    'type_name'=>'account'
                ],
                [
                    'type_label' => 'System Admin',
                    'type_name'=>'systemAdmin'
                ],

                [
                    'type_label' => 'Reception',
                    'type_name'=>'reception'
                ]
            ];
        UsersType::truncate();
        UsersType::insert($userType);
    }
}
