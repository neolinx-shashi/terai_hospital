<?php

use Illuminate\Database\Seeder;

class NationalityTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('nationality')->truncate();

        DB::table('nationality')->insert([
            [
                'short_form_name' => 'Nepal',
                'country_name' => 'Nepali',
                'calling_code' => 'NPL',
            ],
        ]);
    }
}
