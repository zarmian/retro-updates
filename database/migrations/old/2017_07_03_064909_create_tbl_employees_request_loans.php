<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesRequestLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_loans_request', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->date('date');
            $table->string('title')->nullable();
            $table->string('detail')->nullable();
            $table->string('approve_detail')->nullable();
            $table->decimal('amount', 10, 2);
            $table->tinyInteger('status');
            $table->integer('added_by');
            $table->timestamps();
        });

        Schema::table('tbl_employees_loans_request', function($table) {
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
        Schema::dropIfExists('tbl_employees_loans_request');
    }
}
