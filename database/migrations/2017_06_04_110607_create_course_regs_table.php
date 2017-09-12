<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCourseRegsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('course_regs', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('registercourse_id');
            $table->integer('user_id');
            $table->integer('level_id');
            $table->integer('semester_id');
            $table->string('course_title');
            $table->string('course_code');
            $table->string('course_unit');
            $table->string('course_status');
            $table->string('session');
             $table->string('period');
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
        Schema::dropIfExists('course_regs');
    }
}
