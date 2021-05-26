<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdgUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pdg_users', function (Blueprint $table) {
            $table->increments('id');
             $table->string('surname');
            $table->string('firstname');
            $table->string('othername');
            $table->string('matric_number');
            $table->string('jamb_reg');
            $table->integer('student_type');
            $table->integer('programme_id');
            $table->integer('state_id');
            $table->integer('lga_id');
            $table->string('email',100)->unique();
            $table->string('password');
            $table->string('entry_year');
            $table->string('entry_month')->nullable();
            $table->string('student_type')->nullable();;
            $table->string('image_url');
            $table->string('gender');
            $table->string('nationality');
            $table->string('address');
            $table->string('phone');
            $table->string('birthdate')->nullable();
             $table->string('marital_status')->nullable();
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
        Schema::dropIfExists('pdg_users');
    }
}
