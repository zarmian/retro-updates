<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesLoans extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
    	Schema::create('tbl_employees_loans', function (Blueprint $table) {
    	    $table->increments('id');
    	    $table->integer('employee_id')->unsigned();
    	    $table->dateTime('datetime');
            $table->string('detail')->nullable();
    	    $table->decimal('amount', 10, 2);
    	    $table->tinyInteger('type');
    	    $table->integer('added_by');
    	    $table->timestamps();
    	    //
    	});

    	Schema::table('tbl_employees_loans', function($table) {
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
        Schema::dropIfExists('tbl_employees_loans');
    }
}
