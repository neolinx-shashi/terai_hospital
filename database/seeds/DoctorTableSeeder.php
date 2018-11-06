<?php

use Illuminate\Database\Seeder;

class DoctorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('doctors')->truncate();

        DB::table('doctors')->insert([
            [
                'first_name' => 'Chakra',
                'middle_name' => 'Raj',
                'last_name' => 'Pandey',
                'age' => '54',
                'normal_fee' => '500',
                'emergency_fee' => '600',
                'gender' => 'male',
                'department_id' => '1',
                'doctor_code' => 'DOC-CRP',
                'nmc_no' => '5456',
                'address' => 'Mahajargunj, Kathmandu',
                'email' => 'chakra@gmail.com',
                'contact_no' => '9812345678',
                'doctor_description' => 'Orthopedic specialist and senior surgeon.',
            ],
            [
                'first_name' => 'Bhagwan',
                'middle_name' => '',
                'last_name' => 'Koirala',
                'age' => '60',
                'normal_fee' => '500',
                'emergency_fee' => '600',
                'gender' => 'male',
                'department_id' => '2',
                'doctor_code' => 'DOC-BK',
                'nmc_no' => '5454',
                'address' => 'Sitapaila, Kathmandu',
                'email' => 'bhagwan@gmail.com',
                'contact_no' => '9812345678',
                'doctor_description' => 'Senior surgeon.',
            ],
        ]);
    }
}
