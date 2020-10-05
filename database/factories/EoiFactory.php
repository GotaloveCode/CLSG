<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Eoi;
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

$factory->define(Eoi::class, function (Faker $faker) {
    return [
        'date' => $faker->dateTimeBetween('-30 years', 'now'),
        'program_manager' => $faker->word(),
        'fixed_grant' => $faker->word(),
        'variable_grant' => $faker->word(),
        'emergency_intervention' => $faker->word(),
        'operation_costs' => $faker->word(),
        'months' => random_int(-2147483648, 2147483647),
        'water_service_areas' => $faker->realText(),
        'total_people_water_served' => random_int(-2147483648, 2147483647),
        'proportion_served' => $faker->word(),
        'wsp_id' => random_int(1, 10)
    ];
});
