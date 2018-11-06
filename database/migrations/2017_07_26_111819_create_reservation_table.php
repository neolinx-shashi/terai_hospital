<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppointmentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservation', function (Blueprint $table) {
            $table->increments('res_id');
            $table->unsignedInteger('res_doc_id');
            $table->unsignedInteger('res_shift_id');
            $table->string('patient_contact');
            $table->string('pateint_name');
            $table->date('res_date');
            $table->timestamps();

            $table->foreign('res_doc_id')->references('id')->on('doctors')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('res_shift_id')->references('id')->on('shift_setup')
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
        Schema::dropIfExists('reservation');
    }
}
