<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */
use App\EssentialOperation;
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

$factory->define(EssentialOperation::class, function (Faker $faker) {
    return [
        'priority_level' => $faker->word(),
        'essentialfunction_id' => random_int(1, 10),
        'primary_staff' => random_int(-2147483648, 2147483647),
        'backup_staff' => random_int(-2147483648, 2147483647),
        'bcp_id' => random_int(1, 10)
    ];
});
