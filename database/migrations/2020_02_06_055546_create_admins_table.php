<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('users_id');
            $table->string('avatar');
            $table->string('username');
            $table->string('password');
            $table->tinyInteger('status');
            $table->enum('type',["Admin","User"])->default("Admin");
            $table->tinyInteger('categories_view_access');
            $table->tinyInteger('categories_edit_access');
            $table->tinyInteger('categories_full_access');
            $table->tinyInteger('products_access');
            $table->tinyInteger('order_access');
            $table->tinyInteger('users_access');
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
        Schema::dropIfExists('admins');
    }
}
