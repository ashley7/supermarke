<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParchaseDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parchase_details', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('parchase_id')->unsigned();
            $table->integer('stock_id')->unsigned();
            $table->double('quantity',10,2);
            $table->double('unit_price',10,2);

            $table->foreign('parchase_id')->references('id')->on('parchases')->onUpdate('cascade');
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parchase_details');
    }
}
