<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDoctorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->string('age');
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->integer('department_id')->unsigned();
            $table->string('contact_no')->nullable();
            $table->string('nmc_no')->unique();
            $table->string('address');
            $table->string('email');
            $table->string('normal_fee');
            $table->string('emergency_fee')->nullable();
            $table->enum('status', array('Active', 'Inactive'))->default('Active');
            $table->string('image_name')->nullable();
            $table->text('doctor_description')->nullable();
            $table->string('doctor_code');
            $table->string('designation')->nullable();
            $table->string('emergency_contact')->nullable();
            $table->timestamps();

            $table->foreign('department_id')->references('id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('doctors');
    }
}
