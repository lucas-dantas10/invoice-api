<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Invoice>
 */
class InvoiceFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $paid = \fake()->boolean();
        return [
            "user_id" => User::all()->random()->id,
            "type" => fake()->randomElement(['B', 'C', 'P']),
            "paid" => $paid,
            "value" => fake()->numberBetween(1000, 10000),
            'payment_date' => $paid ? fake()->randomElement([fake()->dateTimeThisMonth()]) : NULL,
        ];
    }
}
