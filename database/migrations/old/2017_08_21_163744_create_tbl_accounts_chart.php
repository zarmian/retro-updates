<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblAccountsChart extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_accounts_chart', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 100)->nullable();
            $table->string('name', 255)->nullable();
            $table->integer('type_id')->unsigned()->nullable();
            $table->double('opening_balance')->unsigned()->default(0)->nullable();
            $table->string('account_type', 2)->nullable();
            $table->tinyInteger('is_systemize')->unsigned()->default(0)->nullable();
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
        Schema::dropIfExists('tbl_accounts_chart');
    }
}
