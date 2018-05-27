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
            $table->string('awb');
            $table->string('address');
            $table->string('lat');
            $table->string('long');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->string('city')->nullable();
            $table->string('area')->nullable();
            $table->string('country')->nullable();
            $table->string('street_number')->nullable();
            $table->string('street_name')->nullable();
            $table->timestamp('complete_after');
            $table->timestamp('complete_before');
            $table->string('pick_up_address')->nullable();
            $table->string('pick_up_lat')->nullable();
            $table->string('pick_up_long')->nullable();
            $table->string('total_price');

            // the driver relationship -> Driver (1) to (*) Task
            $table->unsignedInteger('driver_id')->nullable();
            $table->foreign('driver_id')->references('id')->on('drivers');
            // the bulk relationship -> bulk (1) to (*) Task
            $table->unsignedInteger('bulk_id');
            $table->foreign('bulk_id')->references('id')->on('bulks');
            // the company relationship -> Company (1) to (*) Task
            $table->unsignedInteger('company_id');
            $table->foreign('company_id')->references('id')->on('companies');
            // the admin relationship -> admin (1) to (*) Task
            $table->unsignedInteger('created_by')->nullable();

            // the task_status relationship -> task_status (1) to (*) Task
            $table->unsignedInteger('task_status_id');
            $table->foreign('task_status_id')->references('id')->on('task_status');
            // the payment type relationship -> payment types (1) to (*) Task
            $table->unsignedInteger('payment_type_id')->nullable();
            $table->foreign('payment_type_id')->references('id')->on('payment_types');

            $table->timestamps();

            ///
            // $table->primary(['company_id','awb']);
            
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
