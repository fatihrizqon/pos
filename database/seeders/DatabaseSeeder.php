<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Stock;
use App\Models\Order;
use App\Models\Product;
use App\Models\Transaction;
use App\Models\ProductCategory;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        ProductCategory::create([
            'name'       => 'Appetizer'
        ]);

        ProductCategory::create([
            'name'       => 'Main Course'
        ]);

        ProductCategory::create([
            'name'       => 'Snacks'
        ]);

        ProductCategory::create([
            'name'       => 'Dessert'
        ]);

        ProductCategory::create([
            'name'       => 'Drinks'
        ]);

        Product::create([
            'name' => 'Dim Sum',
            'purchase'=> 10000,
            'sell'=> 20000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Sushi',
            'purchase'=> 50000,
            'sell'=> 250000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Seafood Ramen',
            'purchase'=> 25000,
            'sell'=> 100000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Salad',
            'purchase'=> 25000,
            'sell'=> 75000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Potato Fries',
            'purchase'=> 20000,
            'sell'=> 45000,
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Tuna with Salad',
            'purchase'=> 50000,
            'sell'=> 250000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Pasta',
            'purchase'=> 50000,
            'sell'=> 150000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Red Velvet Cake',
            'purchase'=> 40000,
            'sell'=> 120000,
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Raspberry Pudding',
            'purchase'=> 50000,
            'sell'=> 125000,
            'category_id' => 4,
        ]);

        Product::create([
            'name' => 'Mineral Water',
            'purchase'=> 5000,
            'sell'=> 15000,
            'category_id' => 5,
        ]);

        Product::create([
            'name' => 'Juice',
            'purchase'=> 25000,
            'sell'=> 30000,
            'category_id' => 5,
        ]);

        User::factory(5)->create();

        Stock::factory(9)->create();

    }
}
