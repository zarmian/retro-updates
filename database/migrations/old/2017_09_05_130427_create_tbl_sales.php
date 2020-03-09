<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblSales extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('invoice_number')->unsigned()->nullable();
            $table->string('reference')->nullable()->nullable();
            $table->integer('customer_id')->unsigned();
            $table->foreign('customer_id')->references('id')->on('tbl_customers')->onDelete('cascade');
            $table->date('invoice_date')->nullable();
            $table->date('due_date')->nullable();
            $table->double('sub_total')->unsigned()->nullable();
            $table->double('discount')->unsigned()->nullable();
            $table->double('total')->unsigned()->nullable();
            $table->text('note')->nullable();
            $table->integer('added_by')->unsigned()->nullable();
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
        Schema::dropIfExists('tbl_sales');
    }
}
