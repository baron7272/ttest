<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Contestant;
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

$factory->define(Contestant::class, function (Faker $faker) {
    $value=['Single', 'Group'];
    $status=['Evicted', 'Runner','Cancelled','Disqualified','Contestant'];
    $contestant=['Yes', 'No'];
    $g=['Craft','Others','Task','Eadible','Acting','Music', 'Arts','Lifestyle','Tech','Tutor'];
    return [
        'categories' => $g[rand(0,9)],
        'type' => $value[rand(0,1)],
        'status' => $status[rand(0,4)],
        'contestant' => $contestant[rand(0,1)],
        'userIds' => $faker->unique()->numberBetween(0,101),
        'week' => $faker->numberBetween(1,12),
       
    ];
});
