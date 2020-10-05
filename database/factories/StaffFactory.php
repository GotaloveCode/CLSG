<?php

namespace Database\Factories;

use App\Models\Staff;
use Illuminate\Database\Eloquent\Factories\Factory;

class StaffFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Staff::class;

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
            'position' => $this->faker->word(),
            'skills' => $this->faker->realText(),
            'qualifications' => $this->faker->realText(),
            'wsp_id' => random_int(1, 10)
        ];
    }
}

