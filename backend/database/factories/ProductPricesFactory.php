<?php

namespace Database\Factories;

use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ProductPrices>
 */
class ProductPricesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'product_id' => function () {
                return factory(Product::class)->create()->id;
            },
            'price_type_id' => function () {
                return factory(Product::class)->create()->id;
            },
            'amount' => $this->faker->randomFloat(2, 0, 100000),
            'start_date' => $this->faker->dateTimeBetween('-1 years', 'now'),
            'end_date' => $this->faker->dateTimeBetween('now', '+1 years'),
        ];
    }
}
