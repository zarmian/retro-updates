<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSalesDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sales_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('tbl_sales')->onDelete('cascade');
            $table->integer('account_id')->unsigned()->nullable();
            $table->string('description')->nullable();
            $table->double('qty')->default('1');
            $table->double('unit_price')->default('0');
            $table->double('amount')->default('0');
            $table->timestamps();
            //
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_sales_detail');
    }
}
