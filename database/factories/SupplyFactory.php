<?php

namespace Database\Factories;

use App\Models\Supply;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplyFactory extends Factory
{
    protected $model = Supply::class;

    public function definition(): array
    {
    	return [
            'stock_id' => $this->faker->numberBetween(1,9),
            'quantity' => $this->faker->numberBetween(5, 25),
            'user_id' => $this->faker->numberBetween(1,9),
            'supplier_id' => $this->faker->numberBetween(1,9)
    	];
    }
}
