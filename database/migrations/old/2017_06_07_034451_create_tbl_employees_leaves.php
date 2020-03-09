<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblEmployeesLeaves extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_employees_leaves', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('employee_id')->unsigned();
            $table->string('title')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->integer('create_by')->nullable();
            $table->integer('approved_by')->nullable();
            $table->timestamps();
            //
        });

        Schema::table('tbl_employees_leaves', function($table) {
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
        Schema::dropIfExists('tbl_employees_leaves');
    }
}
