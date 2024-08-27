<?php

namespace Database\Factories;

use App\Models\Order;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Order::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'date' => $this->faker->date(),
            'subtotal_amount' => $this->faker->randomNumber(1),
            'shipping_amount' => $this->faker->randomNumber(1),
            'discount' => $this->faker->randomFloat(2, 0, 9999),
            'total_amount' => $this->faker->randomNumber(1),
            'user_id' => \App\Models\User::factory(),
        ];
    }
}
