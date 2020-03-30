<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->unsignedBigInteger('training_id');
            $table->unsignedBigInteger('folder_id');
            $table->unsignedBigInteger('status_id');

            $table->foreign('student_id')->references('id')->on('students');
            $table->foreign('training_id')->references('id')->on('trainings');
            $table->foreign('folder_id')->references('id')->on('folders');
            $table->foreign('status_id')->references('id')->on('registration_statuses');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('registrations');
    }
}
