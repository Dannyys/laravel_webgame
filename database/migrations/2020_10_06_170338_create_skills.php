<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSkills extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('skills', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->tinyInteger('type')->unsigned();
            $table->tinyInteger('sub_type')->unsigned();
        });

        Schema::create('skill_skill_requirement', function (Blueprint $table) {
            $table->bigInteger('skill_id')->unsigned();
            $table->bigInteger('required_skill_id')->unsigned();

            $table->primary(['skill_id', 'required_skill_id']);
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
            $table->foreign('required_skill_id')->references('id')->on('skills')->onDelete('cascade');
        });

        Schema::create('worker_skill', function (Blueprint $table) {
            $table->bigInteger('worker_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();

            $table->primary(['worker_id', 'skill_id']);
            $table->foreign('worker_id')->references('id')->on('workers')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
        Schema::create('task_skill_requirement', function (Blueprint $table) {
            $table->bigInteger('task_id')->unsigned();
            $table->bigInteger('skill_id')->unsigned();

            $table->primary(['task_id', 'skill_id']);
            $table->foreign('task_id')->references('id')->on('tasks')->onDelete('cascade');
            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });

        Schema::create('skill_task_modifier', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('skill_id')->unsigned();
            $table->tinyInteger('task_type')->unsigned();
            $table->tinyInteger('task_sub_type')->unsigned();
            // $table->tinyInteger('speed_modifier')->unsigned();
            $table->tinyInteger('reward_modifier')->unsigned();
            $table->tinyInteger('chance_modifier')->unsigned();

            $table->foreign('skill_id')->references('id')->on('skills')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('skill_task_modifier');
        Schema::dropIfExists('task_skill_requirement');
        Schema::dropIfExists('worker_skill');
        Schema::dropIfExists('skill_skill_requirement');
        Schema::dropIfExists('skills');
    }
}
