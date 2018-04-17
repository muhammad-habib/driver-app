<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTaskOperationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_operations', function (Blueprint $table) {
            $table->increments('id');

            // TODO add created_by

            $table->string('description')->nullable();

            // the task_operation_type relationship -> TaskOperationType (1) to (*) TaskOperation
            $table->unsignedInteger('operation_type_id');

            // the task relationship -> Task (1) to (*) TaskOperation
            $table->unsignedInteger('task_id');

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
        Schema::dropIfExists('task_operations');
    }
}
