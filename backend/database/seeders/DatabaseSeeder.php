<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Database\Seeders\ProductSeeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        \App\Models\Product::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        // $this->call(ProductSeeder::class);
    }
    public function configure()
    {
        return $this->afterCreating(function (Product $product) {
            $product->saveMany(factory(ProductPrice::class, 2)->make());
        });
    }
}
