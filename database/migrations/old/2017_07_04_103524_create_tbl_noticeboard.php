<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblNoticeboard extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_noticeboard', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('datetime')->nullable();
            $table->string('title', 100)->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('type')->unsigned()->nullable();
            $table->tinyInteger('unread')->unsigned()->default('1')->nullable();
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
        Schema::dropIfExists('tbl_noticeboard');
    }
}
