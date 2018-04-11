<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('awb')->unique();
            $table->string('address');
            $table->string('lat');
            $table->string('long');
            $table->string('user_name');
            $table->string('city');
            $table->string('area');

            // the driver relationship -> Driver (1) to (*) Task
            $table->unsignedInteger('driver_id');

            // the batch relationship -> Batch (1) to (*) Task
            $table->unsignedInteger('batch_id');

            // the company relationship -> Company (1) to (*) Task
            $table->unsignedInteger('company_id');


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
        Schema::dropIfExists('tasks');
    }
}
