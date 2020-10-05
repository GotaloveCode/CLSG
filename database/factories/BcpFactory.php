<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\Bcp;
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

$factory->define(Bcp::class, function (Faker $faker) {
    return [
        'excecutive_summary' => BAD_DATATYPE,
        'introduction' => $faker->realText(),
        'planning_assumptions' => $faker->realText(),
        'wsp_id' => random_int(1, 10)
    ];
});
