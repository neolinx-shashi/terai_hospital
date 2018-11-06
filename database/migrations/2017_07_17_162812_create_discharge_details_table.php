<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDischargeDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('discharge_details', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('ipatient_id');
            $table->integer('room_charge')->nullable();
            $table->integer('doctor_charge')->nullable();
            $table->integer('discount')->nullable();
            $table->integer('subtotal_after_discount');
            $table->integer('total_after_tax');
            $table->integer('hst');
            $table->integer('user_id');
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
        Schema::dropIfExists('discharge_details');
    }
}
