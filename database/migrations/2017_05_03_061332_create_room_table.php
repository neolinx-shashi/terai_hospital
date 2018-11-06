<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRoomTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('room', function (Blueprint $table) {
            $table->increments('id');
            $table->string('room_name');
            $table->string('room_type');
            $table->integer('ward_id')->unsigned();
            $table->enum('floor', ['1st Floor', '2nd Floor', 'Ground Floor']);
            $table->string('room_rate')->nullable();
            $table->timestamps();

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
        Schema::dropIfExists('room');

    }
}
