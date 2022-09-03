<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MinisterialInformation>
 */
class MinisterialInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'ministry_performed' => $this->faker->text($maxNbChars = 20),
            'current_ministry' => $this->faker->text($maxNbChars = 20),
            'full_time' => $this->faker->boolean(),
            'ministry_qualification' => $this->faker->text($maxNbChars = 20),
            'aspirated_ministry' => $this->faker->text($maxNbChars = 20),
            'reason_aspiring_ministry' => $this->faker->text($maxNbChars = 40),
            'cicle_to_be_taken' => $this->faker->text($maxNbChars = 10),
            'previous_institution' => $this->faker->text($maxNbChars = 10),
            'last_year_studied' => $this->faker->year(),
            'qualities_religious_worker' => $this->faker->text($maxNbChars = 50),
        ];
    }
}
