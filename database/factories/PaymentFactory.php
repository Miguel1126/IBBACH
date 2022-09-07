<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Payment>
 */
class PaymentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'payment_date'=> $this->faker->date(),
            'last_pay_date'=> $this->faker->date(),
            'sourcharge'=> $this->faker->randomElement([8,2]),
            'rate_id'=> $this->faker->randomElement([1,2]),
            'user_id'=> $this->faker->randomElement([1,2,3,4,5,6,7,8,9,10]),
        ];
    }
}
