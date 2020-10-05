<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Wsp;
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

$factory->define(Wsp::class, function (Faker $faker) {
    $name = $faker->name();
    return [
        'name' => $name,
        'acronym' => substr($name,0,3),
        'postal_address' => $faker->word(),
        'physical_address' => $faker->word(),
        'postal_code_id' => random_int(0, 9223372036854775807)
    ];
});
