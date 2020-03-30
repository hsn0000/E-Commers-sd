<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('category_id',11);
            $table->string('product_name',255);
            $table->string('product_code',255);
            $table->string('product_color',255);
            $table->text('care');
            $table->text('description');
            $table->decimal('price',8,2)->nullable()->default(0);
            $table->string('image',255);
            $table->string('video',255);
            $table->tinyInteger('feature_item')->default(0);
            $table->tinyInteger('status');
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
        Schema::dropIfExists('products');
    }
}
