<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;


/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Order>
 */
class OrderFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'order_date' => fake()->date('d.m.Y'),
            'phone' => fake()->e164PhoneNumber,
            'email' => fake()->email,
            'address' => fake()->address,
            'coordinates' => null,
            'total_sum' => rand(1000, 100000)
        ];
    }
}
