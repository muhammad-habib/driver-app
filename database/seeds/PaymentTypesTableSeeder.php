<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;


class PaymentTypesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
}
