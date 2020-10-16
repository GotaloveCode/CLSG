<?php

namespace Database\Factories;

use App\Models\Revenue;
use Illuminate\Database\Eloquent\Factories\Factory;


class RevenueFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Revenue::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'amount' => random_int(1000, 1200000000),
            'month' => random_int(10, 12),
            'year' => '2020',
            'wsp_id' => random_int(1, 10)
        ];
    }
}



