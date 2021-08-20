<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('type')->unsigned();
            $table->tinyInteger('sub_type')->unsigned();
            $table->smallInteger('base_time')->unsigned();
            $table->mediumInteger('experience_reward')->unsigned()->default(0);
            $table->integer('gold_cost')->unsigned()->default(0);
            $table->integer('gems_cost')->unsigned()->default(0);
        });
        Schema::create('task_material_cost', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();
            $table->mediumInteger('amount')->unsigned();

            $table->primary(['task_id', 'material_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
        Schema::create('task_material_reward', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('material_id')->unsigned();
            $table->smallInteger('base_amount')->unsigned();
            $table->tinyInteger('base_chance')->unsigned();

            $table->primary(['task_id', 'material_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
        Schema::create('task_item_cost', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->mediumInteger('amount')->unsigned();

            $table->primary(['task_id', 'item_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
        Schema::create('task_item_reward', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('item_id')->unsigned();
            $table->smallInteger('base_amount')->unsigned();
            $table->tinyInteger('base_chance')->unsigned();

            $table->primary(['task_id', 'item_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('item_id')->references('id')->on('items')->onDelete('cascade');
        });
        Schema::create('user_task_unlocked', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();

            $table->primary(['task_id', 'user_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::create('task_unlocks_task', function(Blueprint $table){
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('task_to_unlock_id')->unsigned();

            $table->primary(['task_id', 'task_to_unlock_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('task_to_unlock_id')->references('id')->on('tasks')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_unlocks_task');
        Schema::dropIfExists('user_task_unlocked');
        Schema::dropIfExists('task_item_reward');
        Schema::dropIfExists('task_item_cost');
        Schema::dropIfExists('task_material_reward');
        Schema::dropIfExists('task_material_cost');
        Schema::dropIfExists('tasks');
    }
}
