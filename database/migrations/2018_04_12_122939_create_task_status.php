<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskStatus extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('task_status', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title_ar');
            $table->string('title_en');
            $table->string('color');

            $table->integer('priority');
            $table->integer('code');

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
        //
        Schema::dropIfExists('task_status');        
    }
}
