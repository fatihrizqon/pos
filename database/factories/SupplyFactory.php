<?php

namespace Database\Factories;

use App\Models\Supply;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyFactory extends Factory
{
    protected $model = Supply::class;

    public function definition(): array
    {
    	return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(5, 50),
            'user_id' => 1,
            'supplier_id' => Supplier::inRandomOrder()->first()->id,
    	];
    }
}
