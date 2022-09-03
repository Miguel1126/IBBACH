<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EcclesiasticalInformation>
 */
class EcclesiasticalInformationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'is_pastor' => $this->faker->boolean(),
            'is_member' => $this->faker->boolean(),
            'pastor_phone' => $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'church_name' => $this->faker->text($maxNbChars = 50),
            'church_address' => $this->faker->address(),
            'church_phone' => $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'district' => $this->faker->text($maxNbChars = 50),
            'pastor_name' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'licence' => $this->faker->numberBetween($int1 = 10, $int2 = 10000),
            'reference_name_one' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'reference_phone_one' => $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'reference_name_two' => $this->faker->firstName() . ' ' . $this->faker->lastName(),
            'reference_phone_two' => $this->faker->randomNumber($nbDigits = 8, $strict = true),
            'christ_accepted' => $this->faker->text($maxNbChars = 100),
            'christening_date' => $this->faker->date(),
            'time_being_member' => $this->faker->text($maxNbChars = 50),
            'privileges_held' => $this->faker->text($maxNbChars = 50),
            'denomination' => $this->faker->text($maxNbChars = 20),
            'study_reason' => $this->faker->text($maxNbChars = 70),
        ];
    }
}
