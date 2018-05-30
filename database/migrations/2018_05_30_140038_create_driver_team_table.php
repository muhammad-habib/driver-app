<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverTeamTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_team', function (Blueprint $table) {
            $table->increments('id');

            // team
            $table->integer('team_id')->unsigned()->index();
            $table->foreign('team_id')->references('id')->on('teams');

            // driver
            $table->integer('driver_id')->unsigned()->index();
            $table->foreign('driver_id')->references('id')->on('drivers');

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
        Schema::dropIfExists('driver_team');
    }
}
