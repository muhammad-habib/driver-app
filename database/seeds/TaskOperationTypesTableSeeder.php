<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class TaskOperationTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('task_operation_types')->insert([
            array(
                'title_ar' => 'تم الرفض',
                'title_en' => 'Refused',
            ),
        ]);
    }
}
