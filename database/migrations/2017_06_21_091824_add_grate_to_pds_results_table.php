<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddGrateToPdsResultsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pds_results', function (Blueprint $table) {
             $table->string('grade')->after('total')->nullable();
             $table->integer('point')->after('grade')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pds_results', function (Blueprint $table) {
                $table->integer('point');
                $table->string('grade');
        });
    }
}
