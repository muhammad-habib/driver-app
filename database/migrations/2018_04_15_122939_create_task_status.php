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
            $table->string('color'   );

            $table->integer('priority');

            $table->timestamps();
        });

            // Insert some stuff
            DB::table('task_status')->insert([
                array(
                    'title_ar' => 'جديد',
                    'title_en' => 'New',
                    'color' => '#DAA520',
                    'priority' => '1',
                ),
                array(
                    'title_ar' => 'جاهز',
                    'title_en' => 'Ready',
                    'color' => '#1E90FF',
                    'priority' => '1',
                ),
                array(
                    'title_ar' => 'فى الطريق',
                    'title_en' => 'INTRANSIT',
                    'color' => '#FBA15A',
                    'priority' => '1',
                ),
                array(
                    'title_ar' => 'تم التسليم',
                    'title_en' => 'SUCCESSFUL',
                    'color' => 'green',
                    'priority' => '1',
                ),
                array(
                    'title_ar' => 'فشل التسليم',
                    'title_en' => 'FAILED',
                    'color' => 'red',
                    'priority' => '1',
                ),
                ]
            );
            
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
