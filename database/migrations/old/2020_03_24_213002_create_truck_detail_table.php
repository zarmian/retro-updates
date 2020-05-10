<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTruckDetailTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tbl_truck_detail', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('truck_id')->unsigned();
            
            $table->integer('product_id')->unsigned();
            
            $table->double('quantity')->default('0');
            $table->foreign('product_id')->references('id')->on('tbl_items')->onDelete('cascade');
            $table->foreign('truck_id')->references('id')->on('tbl_products')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tbl_truck_detail');
    }
}
