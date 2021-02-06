<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\User;
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

$factory->define(User::class, function (Faker $faker) {
    $gender=['Male', 'Femal'];
    return [
        'firstname' => $faker->firstname,
        'lastname' => $faker->lastname,
        'username' => $faker->username,
        'about' => $faker->username,
        'gender' => $gender[rand(0,1)],
        'occupation' => $faker->sentence(3),
        'country' => $faker->country,
        'age' => $faker->numberBetween(18,102),
        'imageUrl' =>  $faker->imageUrl($width = 200, $height = 200),
        'email' => $faker->unique()->safeEmail,
        'phone' => $faker->unique()->phoneNumber,
        'verifiedAt' => now(),
        'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        
    ];
});
