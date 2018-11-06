<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePatientReportTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patientReport', function(Blueprint $table){
            $table->increments('id');
            $table->string('report_number');
            $table->string('ipatient_code');
            $table->integer('ipatient_id')->unsigned();
            $table->integer('doctor_id')->unsigned();
            $table->string('doctor_report');
            $table->timestamps();



            $table->foreign('ipatient_id')->references('id')->on('ipatient')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('doctor_id')->references('id')->on('doctors')
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
        Schema::dropIfExists('patientReport');

    }
}
