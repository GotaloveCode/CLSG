<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Staff;
use Illuminate\Support\Str;
use Faker\Generator as Faker;
use Carbon\Carbon;

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

$factory->define(Staff::class, function (Faker $faker) {
    return [
        'firstname' => $faker->word(),
        'lastname' => $faker->word(),
        'position' => $faker->word(),
        'skills' => $faker->realText(),
        'qualifications' => $faker->realText(),
        'wsp_id' => random_int(1, 10)
    ];
});
