<?php

namespace Database\Factories;

use Faker\Factory as Faker;
use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

class SupplierFactory extends Factory
{
    protected $model = Supplier::class;

    public function definition(): array
    {
        $faker = Faker::create('id_ID');
    	return [
            'name' => $faker->company(),
            'email' => $faker->unique()->safeEmail(),
            'address' => $faker->address(),
            'contact' => $faker->phoneNumber()
    	];
    }
}
