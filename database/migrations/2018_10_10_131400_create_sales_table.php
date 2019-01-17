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
            $table->integer('stock_id')->unsigned();
            $table->integer('workshift_id')->unsigned();
            $table->double('amount',20,2);//salling price
            $table->double('buying_price',20,2);
            $table->double('discount',20,2)->default(0.00);//money off amount given to buyer
            $table->double('size',20,2);
            $table->string('date_sold');
            
            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('workshift_id')->references('id')->on('work_shifts')->onUpdate('cascade');
            $table->foreign('mainsales_id')->references('id')->on('main_sales')->onUpdate('cascade');
            $table->foreign('stock_id')->references('id')->on('stocks')->onUpdate('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('sales');
    }
}
