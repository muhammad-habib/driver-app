<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 17/04/18
 * Time: 06:32 م
 */
use Faker\Generator as Faker;


$factory->define(\App\Models\Task::class, function (Faker $faker) {
    $lastTask = \App\Models\Task::select('id')->orderBy('id','desc')->first();
    return [
        "id" => $lastTask->id+1,
        "awb" => $faker->biasedNumberBetween(),
        "company_id" => 1,
        "complete_after" => "2018-04-15 13:54:37",
        "complete_before" => "2018-04-15 23:54:37",
        "address" => "cairo",
        "lat" => "123",
        'bulk_id' => $faker->unique()->randomDigit(),
        "long" => "321",
        "customer_name" => "test_customer",
        "customer_phone" => "0123",
        "city" => "lol",
        "area" => "lol",
        "payment_type_id"=>1,
        "country" => "eg",
        "street_number" => "1",
        "street_name" => "st",
        "total_price" => 100,
        "task_status_id" => \App\Enums\Task\ATaskStatus::NEW
    ];
});