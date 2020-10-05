<?php

namespace Database\Factories;

use App\Models\Estimatedcost;
use Illuminate\Database\Eloquent\Factories\Factory;


class EstimatedcostFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Estimatedcost::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name()
        ];
    }
}


