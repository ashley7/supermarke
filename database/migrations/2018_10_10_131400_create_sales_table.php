<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSalesTable extends Migration
{

    public function up()
    {
        Schema::create('sales', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->integer('user_id')->unsigned();
            $table->integer('mainsales_id')->unsigned();
            $table->string('name');
            $table->string('number');
            $table->string('size');
            $table->string('date_sold');
            $table->double('amount',10,2);
            $table->integer('workshift_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('workshift_id')->references('id')->on('work_shifts')->onUpdate('cascade');
            $table->foreign('mainsales_id')->references('id')->on('main_sales')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
