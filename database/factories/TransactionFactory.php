<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
    	return [
            'order_code' => Order::inRandomOrder()->first()->code,
            'total_price' => $this->faker->numberBetween(1, 9) * 10000,
            'user_id' => $this->faker->numberBetween(1,9),
            'status' => $this->faker->numberBetween(1,9)
    	];
    }
}
