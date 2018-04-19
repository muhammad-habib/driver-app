<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TaskStatusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Insert some stuff
        DB::table('task_status')->insert([
                array(
                    'title_ar' => 'جديد',
                    'title_en' => 'New',
                    'color' => '#DAA520',
                    'priority' => '1',
                    'code' => '1',
                ),
                array(
                    'title_ar' => 'جاهز',
                    'title_en' => 'Ready',
                    'color' => '#1E90FF',
                    'priority' => '1',
                    'code' => '2',
                ),
                array(
                    'title_ar' => 'فى الطريق',
                    'title_en' => 'INTRANSIT',
                    'color' => '#FBA15A',
                    'priority' => '1',
                    'code' => '3',
                ),
                array(
                    'title_ar' => 'تم التسليم',
                    'title_en' => 'SUCCESSFUL',
                    'color' => 'green',
                    'priority' => '1',
                    'code' => '4',
                ),
                array(
                    'title_ar' => 'فشل التسليم',
                    'title_en' => 'FAILED',
                    'color' => 'red',
                    'priority' => '1',
                    'code' => '5',
                ),
                array(
                    'title_ar' => 'تم الرفض',
                    'title_en' => 'REFUSED',
                    'color' => 'red',
                    'priority' => '1',
                    'code' => '6',
                ),
                array(
                    'title_ar' => 'تم الوصول',
                    'title_en' => 'ARRIVAL',
                    'color' => 'yellow',
                    'priority' => '1',
                    'code' => '7',
                ),
            ]
        );
    }
}
