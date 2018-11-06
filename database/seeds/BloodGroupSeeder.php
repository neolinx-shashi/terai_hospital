<?php

use Illuminate\Database\Seeder;

class BloodGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('bloodgroup')->truncate();

        DB::table('bloodgroup')->insert([
            [
                'blood_group' => 'A+',
                'rh_factor' => '+',
            ],
            [
                'blood_group' => 'A-',
                'rh_factor' => '-',
            ],
            [
                'blood_group' => 'B+',
                'rh_factor' => '+',
            ],
            [
                'blood_group' => 'B-',
                'rh_factor' => '-',
            ],
            [
                'blood_group' => 'AB+',
                'rh_factor' => '+',
            ],
            [
                'blood_group' => 'AB-',
                'rh_factor' => '-',
            ],
            [
                'blood_group' => 'O+',
                'rh_factor' => '+',
            ],
            [
                'blood_group' => 'O-',
                'rh_factor' => '-',
            ],
        ]);
    }
}
