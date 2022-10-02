<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Supply;
use App\Models\Product;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyFactory extends Factory
{
    protected $model = Supply::class;
    
    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $product = Product::inRandomOrder()->first();
        $supplier = Supplier::inRandomOrder()->first();
    	return [
            'product_id' => $product['id'],
            'quantity' => $this->faker->numberBetween(5, 50),
            'user_id' => $user['id'],
            'supplier_id' => $supplier['id'],
            'created_at' => $this->faker->dateTimeBetween('-1 month', 'today'),
            'updated_at' => $this->faker->dateTimeBetween('-1 month', 'today'),
    	];
    }
}
