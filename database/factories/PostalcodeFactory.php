<?php

namespace Database\Factories;

use App\Models\Postalcode;
use Illuminate\Database\Eloquent\Factories\Factory;


class PostalcodeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Postalcode::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'code' => $this->faker->word(),
            'constituency' => $this->faker->word(),
            'county' => $this->faker->word(),
            'country' => $this->faker->word()
        ];
    }
}



