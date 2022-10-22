<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'subject'=> $this->faker->text($maxNbChars=30),
            'description'=> $this->faker->text($maxNbChars=50),
            'uv'=> $this->faker->randomFloat(1,2,3,4,5,6),
            'level'=> $this->faker->text($maxNbChars=10),
        ];
    }
}
