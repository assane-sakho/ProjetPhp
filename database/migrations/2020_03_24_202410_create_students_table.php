<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('lastname');
            $table->string('firstname');
            $table->string('card_id');
            $table->date('birthdate');
            $table->string('phone_number')->unique();
            $table->string('email')->unique();
            $table->string('password');
            $table->unsignedBigInteger('address_id');
            $table->unsignedBigInteger('registration_id');

            $table->foreign('address_id')->references('id')->on('addresses');
            $table->foreign('registration_id')->references('id')->on('registrations');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('students');
    }
}
