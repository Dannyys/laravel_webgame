<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWorkers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_worker_groups', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('user_id')->unsigned();
            $table->timestamp('task_started_at');
            $table->smallInteger('task_iterations')->unsigned()->nullable();

            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::create('workers', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->uuid('task_worker_group_id')->nullable();
            $table->mediumInteger('experience')->unsigned()->default(0);
            $table->tinyInteger('level')->unsigned()->default(1);
            $table->smallInteger('skill_points')->unsigned()->default(1);
            $table->smallInteger('skill_points_used')->unsigned()->default(0);
            $table->string('name');

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('task_worker_group_id')->references('id')->on('task_worker_groups')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('workers');
        Schema::dropIfExists('task_worker_groups');
    }
}
