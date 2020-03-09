<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesQualifications extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_qualifications', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->string('degree_name')->nullable();
            $table->integer('year')->nullable();
            $table->integer('total_marks')->nullable();
            $table->integer('obtain_marks')->nullable();
            $table->string('grade', 2)->nullable();
            $table->string('institute')->nullable();
        });

        Schema::table('tbl_employees_qualifications', function($table) {
            $table->foreign('employee_id')
              ->references('id')
              ->on('tbl_employees')->onDelete('cascade');
        });
    }


    

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_employees_qualifications');
    }
}
