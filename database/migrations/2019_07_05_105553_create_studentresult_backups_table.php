<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentresultBackupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('studentresult_backups', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('matric_number');
            $table->integer('coursereg_id');
            $table->integer('course_id');
            $table->string('grade');
            $table->string('cu');
            $table->string('cp');
            $table->string('session');
            $table->integer('semester');
            $table->integer('level_id');
            $table->integer('status');
            $table->string('season');
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
        Schema::dropIfExists('studentresult_backups');
    }
}
