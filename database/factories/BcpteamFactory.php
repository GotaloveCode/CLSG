<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Bcpteam;
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

$factory->define(Bcpteam::class, function (Faker $faker) {
    return [
        'firstname' => $faker->word(),
        'lastname' => $faker->word(),
        'unit' => $faker->word(),
        'role' => $faker->word(),
        'training' => $faker->word(),
        'bpi_plan' => $faker->word(),
        'erp' => $faker->word(),
        'bcp_id' => random_int(1, 10)
    ];
});
