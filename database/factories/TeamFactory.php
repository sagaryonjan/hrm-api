<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Team;
use Faker\Generator as Faker;
use Illuminate\Support\Str;

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

$factory->define(Team::class, function (Faker $faker) {
    return [
        'full_name'    => $faker->name,
        'email'        => $faker->email,
        'phone_number' => $faker->phoneNumber,
        'company'      => $faker->company,
        'address'      => $faker->address,
        'about'        => $faker->text,
    ];
});
