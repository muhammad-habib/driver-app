<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWebhooksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('webhooks', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->integer('code');
            $table->string('description_en');
            $table->string('description_ar');
            $table->timestamps();
        });

        // Insert data into table
        DB::table('webhooks')->insert(
            array(
                array(
                    'name' => 'TASK_CREATED',
                    'code' => '1',
                    'description_en' => 'New task created',
                    'description_ar' => 'تم إنشاء مهمة جديدة',
                ),
                array(
                    'name' => 'TASK_ASSIGNED',
                    'code' => '2',
                    'description_en' => 'Task assigned to driver',
                    'description_ar' => 'تم إسناد المهمة للسائق',
                ),
                array(
                    'name' => 'TASK_STARTED',
                    'code' => '3',
                    'description_en' => 'Task started by driver',
                    'description_ar' => 'تم بدء المهمة بواسطة السائق'
                ),
                array(
                    'name' => 'TASK_REFUSED',
                    'code' => '4',
                    'description_en' => 'Task refused by driver',
                    'description_ar' => 'تم رفض المهمة بواسطة السائق'
                ),
                array(
                    'name' => 'TASK_UPDATED',
                    'code' => '5',
                    'description_en' => 'Task updated',
                    'description_ar' => 'تم التعديل على المهمة'
                ),
                array(
                    'name' => 'TASK_ARRIVED',
                    'code' => '6',
                    'description_en' => 'Task arrived by driver',
                    'description_ar' => 'تم توصيل المهمة بواسطة السائق'
                ),
                array(
                    'name' => 'TASK_DELIVERED',
                    'code' => '7',
                    'description_en' => 'Task delivered by driver',
                    'description_ar' => 'تم تسليم المهمة بواسطة السائق'
                ),
                array(
                    'name' => 'TASK_FAILED',
                    'code' => '8',
                    'description_en' => 'Task failed',
                    'description_ar' => 'فشل المهمة'
                )
            )
        );

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
