<?php

namespace Database\Factories;

use App\Models\Eoi;
use Illuminate\Database\Eloquent\Factories\Factory;


class EoiFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Eoi::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => $this->faker->dateTimeBetween('now', '+3 months'),
            'program_manager' => $this->faker->word(),
            'fixed_grant' => $this->faker->word(),
            'variable_grant' => $this->faker->word(),
            'emergency_intervention_total' => random_int(5000, 10000000),
            'operation_costs_total' => random_int(5000, 10000000),
            'months' => random_int(1, 12),
            'water_service_areas' => $this->faker->realText(),
            'total_people_water_served' => random_int(50, 10000000),
            'proportion_served' => $this->faker->word(),
            'wsp_id' => random_int(1, 10)
        ];
    }

    public function published()
    {
        return $this->state([
            'status' => 'published',
        ]);
    }
}


