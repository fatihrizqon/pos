<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Product;
use Faker\Factory as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $faker = Faker::create('id_ID');

    	return [
            'product_id' => Product::inRandomOrder()->first()->id,
            'quantity' => $this->faker->numberBetween(5, 25),
            'price' => $this->faker->numberBetween(1, 9) * 10000,
            'code' => $faker->regexify('[A-Z]{7}[0-4]{3}'),
    	];
    }
}
