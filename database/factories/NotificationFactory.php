<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Notification;
use Illuminate\Support\Str;
use Faker\Generator as Faker;

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| This directory should contain each of the model factory definitions for
| your application. Factories provide a convenient way to generate new
| model instances for testing / seeding your application's database.
|
*/

$factory->define(Notification::class, function (Faker $faker) {
    
       return [
        'title' => $faker->sentence(3),
        'content' => $faker->sentence(13),
        'urlLink' =>  $faker->imageUrl($width = 200, $height = 200),
        
    ];
});
