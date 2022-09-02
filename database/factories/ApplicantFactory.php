<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Applicant>
 */
class ApplicantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'registration_date' => $this->faker->date(),
            'personal_information_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
            'ecclesiastical_information_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
            'ministerial_information_id' => $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20]),
        ];
    }
}
