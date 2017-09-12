<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddNewcolumnToStudentResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('student_results', function (Blueprint $table) {
           $table->string('ca')->after('course_id');
            $table->string('exam')->after('course_id');
            $table->string('total')->after('course_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('student_results', function (Blueprint $table) {
             $table->string('ca');
            $table->string('exam');
            $table->string('total');
        });
    }
}
