<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        //
        'title' => $faker->sentence(3),
        'series_id' => function(){
        return factory(\App\Model\Series::class)->create()->id;
        },
        'description' => $faker->paragraph(4),
        'episode_number' => random_int(1, 100),
        'video_id' => '265045525'
    ];
});
