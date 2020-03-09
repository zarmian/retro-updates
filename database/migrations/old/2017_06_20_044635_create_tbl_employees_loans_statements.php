<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesLoansStatements extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_loans_statements', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->integer('loan_id')->unsigned();
            $table->dateTime('datetime');
            $table->string('detail')->nullable();
            $table->decimal('deposit', 10, 2);
            $table->decimal('withdraw', 10, 2);
            $table->tinyInteger('type');
            $table->integer('added_by');
            $table->timestamps();
        });

        Schema::table('tbl_employees_loans_statements', function($table) {
            $table->foreign('employee_id')->references('id')->on('tbl_employees')->onDelete('cascade');
        });

        Schema::table('tbl_employees_loans_statements', function($table) {
            $table->foreign('loan_id')->references('id')->on('tbl_employees_loans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_employees_loans_statements');
    }
}
