<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Item;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class ItemFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'condition_id' => 1,
            'name' => '腕時計',
            'price' => 15000,
            'brand_name' => 'Rolax',
            'description' => '高級感のある腕時計です。',
            'img_url' => 'Armani-Mens-Clock.jpg',
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Item $item) {
            if ($item->categories->isEmpty()) {
                $category = Category::inRandomOrder()->first();
                if ($category) {
                    $item->categories()->attach($category->id);
                }
            }
        });
    }
}
