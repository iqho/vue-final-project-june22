<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    public function definition()
    {

        return [
            'category_id' => $this->faker->numberBetween(1,8),
            'name' => $name = $this->faker->unique()->name,
            'slug' => Str::slug($name),
            'image' => $this->faker->image(null, 360, 360, 'animals', true),
            'description' => $this->faker->paragraph,          
        ];
    }
}
