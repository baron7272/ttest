<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Wallet;
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

$factory->define(Wallet::class, function (Faker $faker) {
    // $gender=['Male', 'Femal'];
  $a=  ['Credit', 'Debit'];
       return [
       
        'source' => $a[rand(0,3)],
        // 'title' => $faker->sentence(3),
        // 'content' => $faker->sentence(13),
        // 'country' => $faker->country,
        'userId' => $faker->numberBetween(1,100),
        'transferedTo' => $faker->numberBetween(1,100),
        'amount' => $faker->numberBetween(100,100000),
        // 'uploadId' => $faker->unique()->numberBetween(1,100),
        // 'week' => $faker->numberBetween(0,13),
        // 'urlLink' =>  $faker->imageUrl($width = 200, $height = 200),
        // 'email' => $faker->unique()->safeEmail,
        // 'phone' => $faker->unique()->phoneNumber,
        // 'verifiedAt' => now(),
        // 'password' => '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', // password
        
    ];
});
