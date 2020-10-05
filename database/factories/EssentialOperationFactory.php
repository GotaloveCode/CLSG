<?php

namespace Database\Factories;

use App\Models\EssentialOperation;
use Illuminate\Database\Eloquent\Factories\Factory;


class EssentialOperationFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = EssentialOperation::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'priority_level' => $this->faker->word(),
            'essentialfunction_id' => random_int(1, 10),
            'primary_staff' => random_int(1, 2000),
            'backup_staff' => random_int(1, 2000),
            'bcp_id' => random_int(1, 10)
        ];
    }
}



