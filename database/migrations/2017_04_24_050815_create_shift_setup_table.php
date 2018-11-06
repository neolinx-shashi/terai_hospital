<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShiftSetupTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shift_setup', function (Blueprint $table) {
            $table->increments('id');
            $table->string('day_name');
            $table->string('start_time');
            $table->string('end_time');
            $table->enum('status', array('Active', 'Inactive'))->default('Active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shift_setup');
    }
}
