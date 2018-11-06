<?php

use App\Models\DayName;
use Illuminate\Database\Seeder;

class DayNameSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dayName =
            [
                [
                    'name'=>'Sunday'
                    
                ],

                [
                    'name'=>'Monday'
                    
                ],

                [
                    'name'=>'Tuesday'
                    
                ],

                [
                    'name'=>'Wednesday'
                    
                ],

                [
                    'name'=>'Thursday'
                    
                ],

                [
                    'name'=>'Friday'
                    
                ],

                [
                    'name'=>'Saturday'
                    
                ]
              
               
            ];
         DayName::truncate();
         DayName::insert($dayName);



    }
}
