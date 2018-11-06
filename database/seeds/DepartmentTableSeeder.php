<?php

use Illuminate\Database\Seeder;

class DepartmentTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->truncate();

        DB::table('departments')->insert([
            [
                'name' => 'orthopedics',
            ],
            [
                'name' => 'cardiothoracic',
            ],
        ]);
    }
}
