<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateIpatientTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ipatient', function(Blueprint $table){
            $table->increments('id');
            $table->string('first_name');
            $table->string('middle_name')->nullable();
            $table->string('last_name');
            $table->date('patient_dob')->nullable();
            $table->integer('age')->nullable();
            $table->enum('gender', ['Male', 'Female', 'Others']);
            $table->string('bloodGroup_id');
            $table->string('permanent_address');
            $table->string('temporary_address')->nullable();
            $table->string('phone');
            $table->integer('nationality_id')->unsigned();
            $table->enum('marital_status', ['Married', 'Unmarried']);
            $table->string('spouse_name')->nullable();
            $table->string('deposit_amount')->nullable();
            $table->integer('ward_id')->unsigned();
            $table->integer('room_id')->unsigned();
            $table->integer('bed_id')->unsigned();
            $table->string('guardian_name')->nullable();
            $table->string('guardian_relation')->nullable();
            $table->string('guardian_phone')->nullable();
            $table->string('guardian_address')->nullable();
            $table->string('parent_name')->nullable();
            $table->boolean('local_guardian')->nullable();
            $table->string('parent_phone')->nullable();
            $table->string('parent_email')->nullable();
            $table->string('parent_address')->nullable();
            $table->string('parent_occupation')->nullable();
            $table->string('institute_name')->nullable();
            $table->string('institute_address')->nullable();
            $table->string('medic_name')->nullable();
            $table->string('medic_designation')->nullable();
            $table->string('refer_reason')->nullable();
            $table->date('entry_date')->nullable();
            $table->date('release_date')->nullable();
            $table->string('transferLetter_name')->nullable();
            $table->string('labDocument_name')->nullable();
            $table->string('radioDetail_name')->nullable();
            $table->string('surgeryDetail_name')->nullable();
            $table->string('previous_detections')->nullable();
            $table->string('patient_history')->nullable();
            $table->string('prescriptions')->nullable();
            $table->string('discharge_summary')->nullable();
            $table->enum('status', ['In Ward', 'Discharged'])->default('In Ward');
            $table->string('ipatient_code');
            $table->string('patient_type');
            $table->integer('doctor_id')->unsigned()->nullable();
            $table->integer('department_id')->unsigned()->nullable();
            $table->string('doctor_note')->nullable();
            $table->integer('user_id')->unsigned();
            $table->string('discharge_note')->nullable();
            $table->timestamp('discharged_at')->nullable();
            $table->integer('fiscal_year_id')->unsigned();
            $table->timestamps();



            $table->foreign('nationality_id')->references('id')->on('nationality')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('doctor_id')->references('id')->on('doctors')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('ward_id')->references('id')->on('ward')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('room_id')->references('id')->on('room')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('bed_id')->references('id')->on('bed')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            $table->foreign('user_id')->references('id')->on('users')
                ->onUpdate('cascade')
                ->onDelete('restrict');

            /*$table->foreign('id')->references('ipatient_id')->on('i_patient_histories')
                ->onUpdate('cascade')
                ->onDelete('restrict');*/

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
        Schema::dropIfExists('ipatient');

    }
}
