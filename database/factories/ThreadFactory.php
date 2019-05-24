<?php

use Faker\Generator as Faker;

$factory->define(App\Models\Thread::class, function (Faker $faker) {
    // 随机取一个月以内的时间
    $time = $faker->dateTimeThisMonth();

    return [
        'title' => $faker->sentence,
        'body' => $faker->text(50),
        'created_at' => $time,
        'updated_at' => $time,
    ];
});
