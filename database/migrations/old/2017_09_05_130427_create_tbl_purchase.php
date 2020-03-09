<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPurchase extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_purchase', function (Blueprint $table) {
            $table->increments('id');
            $table->decimal('invoice_number')->unsigned()->nullable();
            $table->string('reference')->nullable()->nullable();
            $table->integer('verndor_id')->unsigned();
            $table->foreign('verndor_id')->references('id')->on('tbl_vendors')->onDelete('cascade');
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
        Schema::dropIfExists('tbl_purchase');
    }
}
