<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDriversTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('user_name');
            $table->string('password');
            $table->string('token', 1000)->nullable();
            $table->string('mobile')->nullable();
            $table->string('image')->nullable();
            $table->string('awb')->index()->nullable(); // the delivery service ID
            $table->boolean('active')->default(true)->index();

            // the company relationship -> Company (1) to (*) Driver
            $table->unsignedInteger('company_id')->nullable();
            $table->foreign('company_id')->references('id')->on('companies');

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
        Schema::dropIfExists('drivers');
    }
}
