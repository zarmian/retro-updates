<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblPurchaseLedger extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_purchase_ledger', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('sale_id')->unsigned();
            $table->foreign('sale_id')->references('id')->on('tbl_purchase')->onDelete('cascade');
            $table->integer('account_id')->unsigned();
            $table->foreign('account_id')->references('id')->on('tbl_accounts_chart');
            $table->integer('vendor_id')->unsigned();
            $table->foreign('vendor_id')->references('id')->on('tbl_vendors');
            $table->string('payment_no', 10)->nullable();
            $table->date('date')->nullable();
            $table->string('references', 255)->nullable();
            
            $table->double('amount')->unsigned()->default('0');
            $table->text('description')->nullable();
            $table->integer('added_by')->unsigned();
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
        Schema::dropIfExists('tbl_purchase_ledger');
    }
}
