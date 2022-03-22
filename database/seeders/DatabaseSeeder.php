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
            'name'       => 'Supercar'
        ]);

        ProductCategory::create([
            'name'       => 'Sportcar'
        ]);

        Product::create([
            'name' => '2015 Ferrari FXX K',
            'price' => 3400000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Lamborghini Veneno Roadster',
            'price' => 4500000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'Lamborghini Sesto Elemento',
            'price' => 2200000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => '2013 Bugatti Veyron Grand Sport Vitesse',
            'price' => 2600000,
            'category_id' => 1,
        ]);

        Product::create([
            'name' => 'BMW M2',
            'price' => 58000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'BMW X5',
            'price' => 82000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'BMW 3 Series',
            'price' => 56000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'BMW 4 Series',
            'price' => 58000,
            'category_id' => 2,
        ]);

        Product::create([
            'name' => 'BMW 8 Series',
            'price' => 121000,
            'category_id' => 2,
        ]);

        User::factory(5)->create();

        Stock::factory(9)->create();

    }
}
