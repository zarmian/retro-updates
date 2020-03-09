<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesAttendance extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_attendance', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->timestamp('in_time')->nullable();
            $table->timestamp('out_time')->nullable();
            $table->decimal('time_spent', 20, 2)->default('0')->nullable();
            $table->timestamps();
        });

        Schema::table('tbl_employees_attendance', function($table) {
            $table->foreign('employee_id')->references('id')->on('tbl_employees')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_employees_attendance');
    }
}
