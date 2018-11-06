<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fullname');
            $table->string('email')->unique();
            $table->string('contact_no');
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->string('address');
            $table->string('user_post');
            $table->string('password', 60);
            $table->rememberToken();
            $table->enum('status', ['Pending', 'Active', 'Inactive'])->default('Active');
            $table->string('userimage_name');
            $table->string('ip_address');
            $table->string('browser_agent');
            $table->integer('user_type_id')->unsigned();
            $table->foreign('user_type_id')->references('id')->on('users_type')
                ->onUpdate('cascade')
            ->onDelete('restrict');
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
        Schema::dropIfExists('users');
    }
}
