<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblShiftTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_shift', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('day_id');
            $table->string('start_time');
            $table->string('end_time');
            $table->string('shift_type');
            $table->enum('status', ['Pending', 'Active', 'Inactive']);
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
        Schema::dropIfExists('tbl_shift');
    }
}
