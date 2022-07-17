<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductPrices;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Database\Factories\ProductFactory;
use Database\Factories\ProductPricesFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProductSeeder extends Seeder
{
    public function run()
    {
        // $product = Product::factory()->create()->each(function ($price) {
        //     $price->price()->save($productPrice = ProductPrices::factory()->make());
        // });

        // $this->afterCreating(Product::class, function ($product, $faker) {
        //     $product->saveMany(factory(ProductPrice::class, 2)->make());
        // });

        $product = Product::factory()->make();
    }

    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->saveMany(factory(ProductPrice::class, 2)->make());
        });
    }
}
