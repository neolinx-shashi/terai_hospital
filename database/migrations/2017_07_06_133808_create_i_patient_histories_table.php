<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIPatientHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('i_patient_histories', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ipatient_id');
            $table->string('doctor_id');
            $table->integer('doctor_fee');
            $table->string('appointment');
            $table->string('description')->nullable();
            $table->timestamps();

            $table->foreign('ipatient_id')->references('id')->on('ipatient')
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
        Schema::dropIfExists('i_patient_histories');
    }
}
