<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployees extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees', function (Blueprint $table) {
            $table->increments('id');
            $table->bigInteger('employee_code');
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('username', 100);
            $table->string('password', 100);
            $table->string('email', 100);
            $table->integer('gender');
            $table->integer('maritial_status')->nullable();
            $table->string('national_id')->nullable();
            $table->text('present_address')->nullable();
            $table->text('permanant_address')->nullable();
            $table->string('mobile_no', 20)->nullable();
            $table->string('phone_no', 20)->nullable();
            $table->integer('nationality');
            $table->date('date_of_birth');
            $table->date('joining_date');
            $table->date('leaving_date')->nullable();
            $table->integer('department_id');
            $table->integer('designation_id');
            $table->integer('shift_id');
            $table->integer('employee_type');
            $table->integer('role');
            $table->integer('salary_type');
            $table->double('basic_salary', 15, 8);
            $table->double('accomodation_allowance', 15, 8)->nullable();
            $table->double('medical_allowance', 15, 8)->nullable();
            $table->double('house_rent_allowance', 15, 8)->nullable();
            $table->double('transportation_allowance', 15, 8)->nullable();
            $table->double('food_allowance', 15, 8)->nullable();
            $table->double('overtime_1', 15, 8)->nullable();
            $table->double('overtime_2', 15, 8)->nullable();
            $table->double('overtime_3', 15, 8)->nullable();
            $table->tinyInteger('status');
            $table->string('avatar', 100)->nullable();
            $table->text('reference')->nullable();
            $table->string('remember_token', 100);
            $table->integer('create_by');
            $table->ipAddress('create_ip');
            $table->ipAddress('login_ip')->nullable();
            $table->dateTime('last_login_time')->nullable();
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
        Schema::drop('tbl_employees');
    }
}
