<?php

namespace Database\Factories;

use App\Models\Item;
use App\Models\Purchase;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PurchaseFactory extends Factory
{
    protected $model = Purchase::class;

    public function definition(): array
    {
        return [
            'item_id' => Item::factory(),
            'user_id' => User::factory(),
            'post_code' => $this->faker->postcode(),
            'address' => $this->faker->address(),
            'building' => $this->faker->secondaryAddress(),
            'payment_method' => $this->faker->numberBetween(1, 2),
            'stripe_session_id' => $this->faker->uuid(),
            'status' => 'completed',
        ];
    }
}
