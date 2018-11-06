<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->integer('age');
            $table->text('address');
            $table->string('phone')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->integer('nationality_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->integer('doctor_id')->unsigned();
            $table->string('doctor_fee')->nullable();
            $table->string('appointment');
            $table->text('symptoms')->nullable();
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->string('patient_code');
            $table->string('doctor_fee_with_tax');
            $table->string('patient_type');
            $table->integer('fiscal_year_id')->unsigned();
            $table->integer('user_id')->unsigned();
            $table->string('discount_percent')->nullable();
            $table->string('discounted_fee_value')->nullable();
            $table->string('doctor_tax_only')->nullable();

            $table->timestamps();

            $table->foreign('nationality_id')->references('id')->on('nationality')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('department_id')->references('id')->on('departments')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('fiscal_year_id')->references('id')->on('fiscal_year')
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
        Schema::dropIfExists('patients');
    }
}
