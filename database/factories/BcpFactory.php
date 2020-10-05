<?php

namespace Database\Factories;

use App\Models\Bcp;
use Illuminate\Database\Eloquent\Factories\Factory;


class BcpFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Bcp::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'executive_summary' => $this->faker->realText(),
            'introduction' => $this->faker->realText(),
            'planning_assumptions' => $this->faker->realText(),
            'wsp_id' => random_int(1, 10)
        ];
    }
}



