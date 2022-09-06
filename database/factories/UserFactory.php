<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->firstName() . $this->faker->firstName(),
            'last_name' => $this->faker->lastName() . $this->faker->lastName(),
            'code' => $this->faker->unique->text($maxNbChars = 7),
            'password' => Hash::make('12345'),
            'role' => 'docente',
        ];
    }
}
