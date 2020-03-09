<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesOfficialLeavesDates extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_official_leaves_dates', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('leave_id')->unsigned();
            $table->date('leave_date')->nullable();
            //
        });

        Schema::table('tbl_employees_official_leaves_dates', function($table) {
            $table->foreign('leave_id')->references('id')->on('tbl_employees_official_leaves')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_employees_official_leaves_dates');
    }
}
