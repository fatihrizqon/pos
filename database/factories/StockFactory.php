<?php

namespace Database\Factories;

use App\Models\Stock;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class StockFactory extends Factory
{
    protected $model = Stock::class;

    public function definition(): array
    {
    	return [
            'product_id' => Product::orderBy('id')->first()->id,
            'quantity' => $this->faker->numberBetween(5, 125),
    	];
    }
}
