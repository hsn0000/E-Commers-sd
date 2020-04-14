<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShippingChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shipping_charges', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('country_code',2);
            $table->string('country',255);
            $table->float('shipping_charges');
            $table->float('shipping_charges0_500g');
            $table->float('shipping_charges501_1000g');
            $table->float('shipping_charges1001_2000g');
            $table->float('shipping_charges2001_5000g');
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
        Schema::dropIfExists('shipping_charges');
    }
}
