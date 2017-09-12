<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('results', function (Blueprint $table) {
            $table->increments('id');
             $table->integer('user_id');
            $table->string('matric_number');
            $table->string('session');
            $table->integer('semester');
            $table->decimal('ca',10,2);
            $table->decimal('exam',10,2);
            $table->decimal('mark',10,2);
              $table->string('grade');
            $table->string('cu');
              $table->string('cp');
            $table->integer('level_id');
            $table->integer('registercourse_id');
            $table->integer('status');
            $table->string('season');
            $table->string('flag');
            $table->integer('examofficer');
            $table->integer('approved');
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
        Schema::dropIfExists('results');
    }
}
