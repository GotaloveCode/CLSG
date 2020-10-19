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
            'rationale' => $this->faker->realText(),
            'environment_analysis' => $this->faker->realText(),
            'company_overview' => $this->faker->realText(),
            'financing' => $this->faker->realText(),
            'strategic_direction' => $this->faker->realText(),
            'wsp_id' => random_int(1, 10)
        ];
    }
}



