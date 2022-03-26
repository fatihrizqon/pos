<?php

namespace Database\Factories;

use App\Models\Stock;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
    	return [
            'product_id' => $this->faker->unique()->numberBetween(1, 9),
            'quantity' => $this->faker->numberBetween(5, 125),
    	];
    }
}
