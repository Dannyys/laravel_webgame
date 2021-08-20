<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UserFriends extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_friend', function(Blueprint $table){
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('friend_id')->unsigned();
            // $table->boolean('accepted');

            $table->primary(['user_id', 'friend_id']);
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('friend_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_friend');
    }
}
