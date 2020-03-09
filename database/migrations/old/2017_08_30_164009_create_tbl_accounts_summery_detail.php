<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountsSummeryDetail extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accounts_summery_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('summery_id')->unsigned()->nullable();
            $table->foreign('summery_id')->references('id')->on('tbl_accounts_summery')->onDelete('cascade');
            $table->integer('account_id')->unsigned()->nullable();
            $table->foreign('account_id')->references('id')->on('tbl_accounts_chart')->onDelete('cascade');
            $table->date('date')->nullable();
            $table->double('debit')->unsigned()->default('0')->nullable();
            $table->double('credit')->unsigned()->default('0')->nullable();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('tbl_accounts_summery_detail');
    }
}
