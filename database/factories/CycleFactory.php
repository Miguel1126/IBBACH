<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cycle>
 */
class CycleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'cycle'=> $this->faker->randomElement(['01','02']) . '/' . $this->faker->year(),
            'start_date'=> $this->faker->date(),
            'end_date'=> $this->faker->date(),
            'group_id'=> $this->faker->randomElement([1,2]),
        ];
    }
}
