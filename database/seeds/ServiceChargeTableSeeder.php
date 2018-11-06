<?php

use Illuminate\Database\Seeder;

class ServiceChargeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('service_charges')->truncate();

        DB::table('service_charges')->insert([
            [
                'name' => 'Service Charge',
                'percent' => '10',
            ],
            [
                'name' => 'VAT',
                'percent' => '13',
            ],
        ]);
    }
}
