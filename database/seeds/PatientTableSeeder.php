<?php

use Illuminate\Database\Seeder;

class PatientTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('patients')->truncate();

        DB::table('patients')->insert([
            [
                'first_name' => 'Sanjay',
                'middle_name' => '',
                'last_name' => 'Bhandari',
                'age' => '22',
                'phone' => '9841223344',
                'gender' => 'male',
                'per_address' => 'Pharping, Kathmandu',
                'temp_address' => 'Koteshwor, Kathmandu',
                'nationality_id' => '1',
                'symptom' => 'Severe fever and vomiting.',
                'department_id' => '1',
                'doctorname_id' => '1',
                'doctorfee_id' => '1',
            ],
            [
                'first_name' => 'Ramesh',
                'middle_name' => '',
                'last_name' => 'Maharjan',
                'age' => '23',
                'phone' => '9841223344',
                'gender' => 'male',
                'per_address' => 'Harisiddhi, Lalitpur',
                'temp_address' => 'Harisiddhi, Lalitpur',
                'nationality_id' => '2',
                'symptom' => 'Severe back pain.',
                'department_id' => '2',
                'doctorname_id' => '2',
                'doctorfee_id' => '2',
            ]
        ]);
    }
}
