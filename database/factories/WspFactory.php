<?php

namespace Database\Factories;

use App\Models\Wsp;
use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Factories\Factory;

class WspFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Wsp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $name = $this->faker->company;
        return [
            'name' => $name,
            'acronym' => substr($name,0,3),
            'email' => $this->faker->safeEmail(),
            'postal_address' => $this->faker->word(),
            'physical_address' => $this->faker->word(),
            'postal_code_id' => PostalCode::get()->random()->id
        ];
    }
}

