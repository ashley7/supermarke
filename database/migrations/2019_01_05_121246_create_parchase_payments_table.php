<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateParchasePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('parchase_payments', function (Blueprint $table) {
            $table->increments('id');
            $table->timestamps();
            $table->double('amount')->default(0.00);
            $table->integer('parchase_id')->unsigned();
            $table->foreign('parchase_id')->references('id')->on('parchases')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('parchase_payments');
    }
}
