<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountsSummery extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accounts_summery', function (Blueprint $table) {
            $table->increments('id');
            $table->date('date')->nullable();
            $table->string('reference', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->unsigned()->default('1');
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
        Schema::dropIfExists('tbl_accounts_summery');
    }
}
