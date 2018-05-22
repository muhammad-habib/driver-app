<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableCompanyWebhoook extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_webhook', function (Blueprint $table) {
            $table->increments('id');

            $table->integer('company_id')->unsigned()->index();      
            $table->integer('webhook_id')->unsigned()->index();

            $table->string('url');
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
       Schema::dropIfExists('webhooks');
    }
}
