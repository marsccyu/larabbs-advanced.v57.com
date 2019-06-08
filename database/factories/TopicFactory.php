<?php

use Faker\Generator as Faker;
use Illuminate\Support\Str;
use App\Models\Channel;

$factory->define(App\Models\Topic::class, function (Faker $faker) {

    $sentence = $faker->sentence();

    // 随机取一个月以内的时间
    $updated_at = $faker->dateTimeThisMonth();

    // 传参为生成最大时间不超过，因为创建时间需永远比更改时间要早
    $created_at = $faker->dateTimeThisMonth($updated_at);

    return [
        'channel_id' => function() {
            return factory(Channel::class)->create()->id;
        },
        'title' => $sentence,
        'body' => $faker->text(),
        'excerpt' => $sentence,
        'slug' => Str::random(),
        'created_at' => $created_at,
        'updated_at' => $updated_at,
    ];
});
