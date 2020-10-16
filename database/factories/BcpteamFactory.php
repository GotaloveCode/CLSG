<?php

namespace Database\Factories;

use App\Models\Bcpteam;
use Illuminate\Database\Eloquent\Factories\Factory;


class BcpteamFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bcpteam::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'firstname' => $this->faker->word(),
            'lastname' => $this->faker->word(),
            'unit' => $this->faker->word(),
            'role' => $this->faker->word(),
            'training' => $this->faker->word(),
            'bpi_plan' => $this->faker->word(),
            'erp' => $this->faker->word(),
            'bcp_id' => random_int(1, 10)
        ];
    }
}

