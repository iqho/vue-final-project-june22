<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payment_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('payment_method_id')->unsigned();
            $table->bigInteger('order_id')->unsigned();

            $table->text('payment_meta')->nullable();

            $table->timestamps();
            $table->softDeletes();

            $table->foreign('payment_method_id')->references('id')->on('payment_methods')->onUpdate('cascade')->onDelete('restrict');
            $table->foreign('order_id')->references('id')->on('orders')->onUpdate('cascade')->onDelete('restrict');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payment_details');
    }
};
