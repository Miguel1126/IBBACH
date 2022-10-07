<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Schedule>
 */
class ScheduleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'start_time'=> $this->faker->time(),
            'end_time'=> $this->faker->time(),
            'start_date' => $this->faker->date(),
            'end_date' => $this->faker->date()
        ];
    }
}
