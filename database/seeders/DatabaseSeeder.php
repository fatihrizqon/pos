<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Order;
use App\Models\Stock;

use App\Models\Supply;
use App\Models\Product;
use App\Models\Supplier;
use App\Models\Transaction;
use Faker\Factory as Faker;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class DatabaseSeeder extends Seeder
{

    public function run()
    {
        $faker = Faker::create('id_ID');

        $users = [
            [
                'name' => 'Super Administrator',
                'username' => 'superadmin',
                'email' => 'superadmin@pointofsaleku.id',
                'gender' => 'male',
                'password' => Hash::make('123123'),
                'phone' => '',
                'role' => 7,
            ],
        ];
        $categories = [
            [
                'name' => 'Appetizer'
            ],
            [
                'name' => 'Main Course'
            ],
            [
                'name' => 'Snack'
            ],
            [
                'name' => 'Dessert'
            ],
            [
                'name' => 'Drink'
            ],
        ];
        $products = [
            [
                'name' => 'Dim Sum',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 10000,
                'sell'=> 20000,
                'category_id' => 1,
            ],
            [
                'name' => 'Sushi',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 50000,
                'sell'=> 150000,
                'category_id' => 2,
            ],
            [
                'name' => 'Seafood Ramen',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 25000,
                'sell'=> 100000,
                'category_id' => 2,
            ],
            [
                'name' => 'Salad',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 25000,
                'sell'=> 75000,
                'category_id' => 1,
            ],
            [
                'name' => 'Fries Potato',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 20000,
                'sell'=> 45000,
                'category_id' => 3,
            ],
            [
                'name' => 'Tuna with Salad',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 50000,
                'sell'=> 250000,
                'category_id' => 2,
            ],
            [
                'name' => 'Pasta',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 50000,
                'sell'=> 150000,
                'category_id' => 2,
            ],
            [
                'name' => 'Red Velvet Cake',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 40000,
                'sell'=> 120000,
                'category_id' => 3,
            ],
            [
                'name' => 'Raspberry Pudding',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 50000,
                'sell'=> 125000,
                'category_id' => 4,
            ],
            [
                'name' => 'Mineral Water',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 5000,
                'sell'=> 15000,
                'category_id' => 5,
            ],
            [
                'name' => 'Juice',
                'code' => $faker->regexify('[A-Z]{5}[0-4]{3}'),
                'purchase'=> 25000,
                'sell'=> 30000,
                'category_id' => 5,
            ],
        ];
        for ($i=0; $i < count($users); $i++) { 
            User::create($users[$i]);
        }
        for ($i=0; $i < count($categories); $i++) { 
            // ProductCategory::create($categories[$i]);
        }
        for ($i=0; $i < count($products); $i++) { 
            // Product::create($products[$i]);
        }

        // Supplier::factory(9)->create();
        // User::factory(9)->create();
        
        // Supplier::create([
        //     'id' => 1,
        //     'name' => 'Default Supplier',
        //     'address' => 'Default Street',
        //     'email' => 'default@mail.id',
        //     'contact' => '081249977970'
        // ]);
        // Supply::factory(9)->create();
        // Order::factory(200)->create();
        // Transaction::factory(100)->create();
    }
}
