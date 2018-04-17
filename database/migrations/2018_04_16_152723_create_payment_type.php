<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //
        Schema::create('payment_type', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title_ar');
            $table->string('title_en');

            $table->unsignedInteger('code');

            // the company relationship -> Company (1) to (*) Task
            $table->unsignedInteger('company_id');

            $table->timestamps();

        });

                    // Insert some stuff
                    DB::table('payment_type')->insert([
                        array(
                            'title_ar' => 'كاش',
                            'title_en' => 'Cash',
                            'company_id'=>1,
                            'code' => '1',
                        ),
                        array(
                            'title_ar' => 'mada',
                            'title_en' => 'مدا',
                            'company_id'=>1,
                            'code' => '2',
                        ),
                        array(
                            'title_ar' => 'لول',
                            'title_en' => 'Lol',
                            'company_id'=>1,
                            'code' => '3',
                        )]);
        

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('payment_type');
    }
}
