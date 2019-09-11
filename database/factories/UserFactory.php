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
    return [
//        'user_name' => $faker->name,
        'username' => "super-admin",
        'password' =>  bcrypt(123123),
        'api_token' => Str::random(60),
        'user_level' => 'kominfo',
        'remember_token' => Str::random(60),
    ];
});
