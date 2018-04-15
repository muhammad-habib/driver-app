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
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('city');
            $table->string('area');
            $table->string('country');
            $table->string('street_number');
            $table->string('street_name');
            $table->timestamp('complete_after');
            $table->timestamp('complete_before');
            $table->string('pick_up_address');
            $table->string('pick_up_lat');
            $table->string('pick_up_long');
            

            // the driver relationship -> Driver (1) to (*) Task
            $table->unsignedInteger('driver_id');

            // the bulk relationship -> bulk (1) to (*) Task
            $table->unsignedInteger('bulk_id');

            // the company relationship -> Company (1) to (*) Task
            $table->unsignedInteger('company_id');

            // the admin relationship -> admin (1) to (*) Task
            $table->unsignedInteger('created_by');

            // the task_status relationship -> task_status (1) to (*) Task
            $table->unsignedInteger('task_status_id');
            
            // the driver relationship -> Driver (1) to (*) Task
            $table->unsignedInteger('payment_type_id');

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
