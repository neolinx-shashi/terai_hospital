<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBedTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bed', function (Blueprint $table) {
            $table->increments('id');
            $table->string('bed_name');
            $table->integer('ward_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->enum('availability',['Available', 'Unavailable'])->default('Available');
            $table->timestamps();

            $table->foreign('room_id')->references('id')->on('room')
                ->onUpdate('cascade')
                ->onDelete('restrict');
            $table->foreign('ward_id')->references('id')->on('ward')
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
        Schema::dropIfExists('bed');

    }
}
