<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTblLoginAttempt extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_login_attempt', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('login_count');
            $table->ipAddress('ip_address');
            $table->string('time', 100);
            $table->timestamps('last_login_attempt');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_login_attempt');
    }
}
