<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumInteger('base_value')->unsigned();
            $table->tinyInteger('value_mod')->default(0);
        });
        Schema::create('user_item', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->mediumInteger('amount')->unsigned();

            $table->primary(['user_id', 'item_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_item');
        Schema::dropIfExists('items');
    }
}
