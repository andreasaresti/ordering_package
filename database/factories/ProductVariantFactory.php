<?php

namespace Database\Factories;

use Illuminate\Support\Str;
use App\Models\ProductVariant;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'color' => $this->faker->hexcolor(),
            'size' => $this->faker->randomFloat(2, 0, 9999),
            'price' => $this->faker->randomFloat(2, 0, 9999),
        ];
    }
}
