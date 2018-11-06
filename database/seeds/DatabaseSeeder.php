<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;



class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()

    {
         DB::statement('SET FOREIGN_KEY_CHECKS=0;');

         $this->call('UsersTypeTableSeeder');
         $this->call('UsersTableSeeder');
         $this->call('DepartmentTableSeeder');
         $this->call('NationalityTableSeeder');
         $this->call('ServiceChargeTableSeeder');
         $this->call('DayNameSeeder');
         $this->call('BloodGroupSeeder');

          DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }
}
