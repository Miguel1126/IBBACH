<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonalInformation>
 */
class PersonalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName() . ' ' . $this->faker->firstName(),
            'last_name' => $this->faker->lastName() . ' ' . $this->faker->lastName(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'address' => $this->faker->address(),
            'nationality' => $this->faker->country(),
            'birth_date' => $this->faker->date(),
            'marital_status' => $this->faker->randomElement(['Casado/a', 'Soltero/a', 'Divorsiado/a', 'Viudo/a']),
            'mate_name' => $this->faker->name(),
            'secular_degree' => $this->faker->text($maxNbChars = 50),
            'current_ocupation' => $this->faker->jobTitle(),
        ];
    }
}
