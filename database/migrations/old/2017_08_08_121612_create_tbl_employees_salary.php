<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesSalary extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_salary', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned()->nullable();
            $table->date('salary_date')->nullable();
            $table->double('basic_pay')->unsigned()->nullable();
            $table->double('accomodation')->unsigned()->nullable();
            $table->double('medical')->unsigned()->nullable();
            $table->double('house_rent')->unsigned()->nullable();
            $table->double('transportation')->unsigned()->nullable();
            $table->double('food')->unsigned()->nullable();
            $table->double('overtime')->unsigned()->nullable();
            $table->double('deduction')->unsigned()->nullable();
            $table->double('fix_advance')->unsigned()->nullable();
            $table->double('temp_advance')->unsigned()->nullable();
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
        Schema::dropIfExists('tbl_employees_salary');
    }
}
