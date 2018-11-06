<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('nurses', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('age');
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->string('contact_no');
            $table->string('nmc_no')->unique();
            $table->string('address');
            $table->string('email')->unique();
            $table->enum('status', array('Active', 'Inactive'))->default('Active');
            $table->string('image_name')->nullable();
            $table->text('nurse_description')->nullable();
            $table->string('nurse_code');
            $table->integer('department_id');
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
        Schema::dropIfExists('nurses');
    }
}
