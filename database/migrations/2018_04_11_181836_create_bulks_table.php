<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBulksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bulks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('awb');

            // the driver relationship -> Driver (1) to (*) bulk
            $table->unsignedInteger('driver_id')->nullable();

            // the company relationship -> Company (1) to (*) bulk
            $table->unsignedInteger('company_id');

            // the admin relationship -> Admin (1) to (*) bulk
            $table->unsignedInteger('admin_id')->nullable();

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
        Schema::dropIfExists('bulks');
    }
}
