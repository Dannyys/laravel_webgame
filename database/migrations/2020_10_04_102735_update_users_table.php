<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table('users', function (Blueprint $table) {
            $table->renameColumn('name', 'username');
            $table->tinyInteger('role')->default(0)->unsigned();

            $table->bigInteger('gold')->default(1000)->unsigned();
            $table->bigInteger('gems')->default(0)->unsigned();
            $table->bigInteger('points')->default(0)->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function ($table) {
            $table->renameColumn('username', 'name');
            $table->dropColumn('role');
            $table->dropColumn('gold');
            $table->dropColumn('gems');
            $table->dropColumn('points');
        });
    }
}
