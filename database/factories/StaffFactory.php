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
            'firstname' => $this->faker->firstName(),
            'lastname' => $this->faker->lastName,
            'position' => $this->faker->jobTitle,
            'skills' => $this->faker->realText(),
            'qualifications' => $this->faker->realText(),
            'wsp_id' => random_int(1, 10)
        ];
    }

    public function essential()
    {
        return $this->state([
            'type' => 'Essential',
        ]);
    }

    public function backup()
    {
        return $this->state([
            'type' => 'Backup',
        ]);
    }
}

