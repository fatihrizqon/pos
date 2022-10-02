<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use Illuminate\Database\Eloquent\Factories\Factory;

class TransactionFactory extends Factory
{
    protected $model = Transaction::class;

    public function definition(): array
    {
        $user = User::inRandomOrder()->first();
        $order = Order::inRandomOrder()->first();
        $product = Product::where('id', $order['product_id'])->get()->first();
    	return [
            'order_code' => $order['code'],
            'revenue' => $order['quantity'] * $product['sell'],
            'pay' => $order['quantity'] * $product['sell'],
            'return' => 0,
            'user_id' => $user['id'],
            'status' => $this->faker->numberBetween(1,9),
            'created_at' => $order['created_at'],
            'updated_at' => $order['updated_at'],
    	];
    }
}
