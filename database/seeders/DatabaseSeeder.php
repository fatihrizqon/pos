<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\Stock;
use App\Models\Order;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Supply;
use App\Models\Transaction;
use App\Models\ProductCategory;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create('id_ID');

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
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 10000,
            'sell'=> 20000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Sushi',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 50000,
            'sell'=> 250000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Seafood Ramen',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 25000,
            'sell'=> 100000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Salad',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 25000,
            'sell'=> 75000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Potato Fries',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 20000,
            'sell'=> 45000,
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Tuna with Salad',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 50000,
            'sell'=> 250000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Pasta',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 50000,
            'sell'=> 150000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'Red Velvet Cake',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 40000,
            'sell'=> 120000,
            'category_id' => 3,
        ]);

        Product::create([
            'name' => 'Raspberry Pudding',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 50000,
            'sell'=> 125000,
            'category_id' => 4,
        ]);

        Product::create([
            'name' => 'Mineral Water',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 5000,
            'sell'=> 15000,
            'category_id' => 5,
        ]);

        Product::create([
            'name' => 'Juice',
            'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
            'purchase'=> 25000,
            'sell'=> 30000,
            'category_id' => 5,
        ]);

        Supplier::create([
            'id' => 1,
            'name' => 'Default Supplier',
            'address' => 'Default Street',
            'email' => 'default@mail.id',
            'contact' => '081249977970'
        ]);

        // Supplier::factory(9)->create();

        // Supply::factory(9)->create();

        // User::factory(9)->create();

        // Order::factory(200)->create();
        
        // Transaction::factory(200)->create();

    }
}
