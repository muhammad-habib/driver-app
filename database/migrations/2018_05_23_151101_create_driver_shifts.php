<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriverShifts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('driver_shifts', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('driver_id')->unsigned()->index();
            $table->foreign('driver_id')->references('id')->on('drivers');

            $table->time('start_at');
            $table->time('end_at')->nullable();

            $table->timestamps();
        });

        Schema::table('drivers', function(Blueprint $table){
            $table->smallInteger('in_duty')->default(0);
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_shifts');

        Schema::table('drivers', function(Blueprint $table){
            $table->dropColumn('in_duty');
        });
    }
}
