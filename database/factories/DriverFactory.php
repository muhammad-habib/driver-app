<?php
/**
 * Created by PhpStorm.
 * User: terminator
 * Date: 17/04/18
 * Time: 06:32 م
 */
use Faker\Generator as Faker;

$factory->define(\App\Models\Driver::class, function (Faker $faker) {
    $lastDriver = \App\Models\Driver::select('id')->orderBy('id','desc')->first();
    return [
        "id" => $lastDriver->id+1,
        "name" => $faker->name(),
        "awb" => $faker->biasedNumberBetween(),
        "active" => true,
        "on_duty" => false,
        "company_id" => 1
    ];
});