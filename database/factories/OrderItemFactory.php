<?php

namespace Database\Factories;

use App\Models\OrderItem;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderItemFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = OrderItem::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'price' => $this->faker->randomFloat(2, 0, 9999),
            'quantity' => $this->faker->randomNumber(),
            'total_price' => $this->faker->randomNumber(1),
            'order_id' => \App\Models\Order::factory(),
            'product_id' => \App\Models\Product::factory(),
            'product_variant_id' => \App\Models\ProductVariant::factory(),
        ];
    }
}
