<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBillingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('billing_detail', function (Blueprint $table) {
            $table->increments('bid');
            $table->integer('patient_id');
            $table->integer('doctor_id');
            $table->integer('consulting_doctor_id')->default('0');
            $table->date('date');
            $table->integer('sub_total');
            $table->integer('tax');
            $table->integer('discount');
            $table->integer('grand_total');
            $table->integer('user_id');
            $table->enum('status', array('Active', 'Inactive'))->default('Active');
            $table->timestamps();

            /*$table->foreign('patient_id')->references('id')->on('patients')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');*/
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('billing_detail');
    }
}
