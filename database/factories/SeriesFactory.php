<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model\Series;
use Faker\Generator as Faker;

$factory->define(Series::class, function (Faker $faker) {
    $title = $faker->sentence(5);
    return [
        //
        'title' => $title,
        'slug' => \Illuminate\Support\Str::slug($title),
//        'image_url' => $faker->imageUrl(),
        'image_url' => 'series/'.\Illuminate\Support\Str::slug($title).'.png',
        'description' => $faker->paragraph()
    ];
});
