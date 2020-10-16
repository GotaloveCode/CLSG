<?php

namespace Database\Factories;

use App\Models\Essentialfunction;
use Illuminate\Database\Eloquent\Factories\Factory;


class EssentialfunctionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Essentialfunction::class;

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


