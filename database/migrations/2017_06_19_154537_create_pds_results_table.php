<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePdsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pds_results', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('pdg_user');
            $table->string('matric_number');
            $table->integer('course');
            $table->string('ca');
            $table->string('exam');
             $table->string('total');
            $table->string('session');
            $table->integer('semester');
            $table->integer('examofficer');
            $table->dateTime('date');
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
        Schema::dropIfExists('pds_results');
    }
}
