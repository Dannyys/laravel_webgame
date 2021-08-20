<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMaterials extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('materials', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->mediumInteger('base_value')->unsigned();
        });
        Schema::create('user_material', function (Blueprint $table) {
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();
            $table->mediumInteger('amount')->unsigned();

            $table->primary(['user_id', 'material_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_material');
        Schema::dropIfExists('materials');
    }
}
