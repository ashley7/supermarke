<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMainSalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_sales', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->string('sales_number')->unique();
            // $table->string('client')->default("Client");
            $table->integer('customer_id')->unsigned()->nullable();
            $table->integer('user_id')->unsigned();
            $table->integer('period_recorded')->unsigned();
            $table->integer('workshift_id')->unsigned()->nullable();

            $table->foreign('user_id')->references('id')->on('users')->onUpdate('cascade');
            $table->foreign('workshift_id')->references('id')->on('work_shifts')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('main_sales');
    }
}
