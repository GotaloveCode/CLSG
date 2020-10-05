<?php

namespace Database\Factories;

use App\Models\Contractor;
use Illuminate\Database\Eloquent\Factories\Factory;


class ContractorFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Contractor::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name(),
            'postal_address' => $this->faker->word(),
            'physical_address' => $this->faker->word(),
            'postal_code_id' => random_int(1, 10),
            'phone' => $this->faker->word(),
            'email' => $this->faker->unique()->safeEmail
        ];
    }
}



