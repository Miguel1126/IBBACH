<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Note>
 */
class NoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ev1'=> $this->faker->randomFloat(1, 20, 30),
            'percentege1'=> $this->faker->randomFloat(1, 20, 30),
            'ev2'=> $this->faker->randomFloat(1, 20, 30),
            'percentege2'=> $this->faker->randomFloat(1, 20, 30),
            'ev3'=> $this->faker->randomFloat(1, 20, 30),
            'percentege3'=> $this->faker->randomFloat(1, 20, 30),
            'ev4'=> $this->faker->randomFloat(1, 20, 30),
            'percentege4'=> $this->faker->randomFloat(1, 20, 30),
            'ev5'=> $this->faker->randomFloat(1, 20, 30),
            'percentege5'=> $this->faker->randomFloat(1, 20, 30),
            'finalAverage'=> $this->faker->randomFloat(1, 20, 30),
            'inscription_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),

        ];
    }
}
