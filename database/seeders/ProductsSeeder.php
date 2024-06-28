<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = \Faker\Factory::create();
        for ($i = 0; $i < 10; $i++) {
            Product::create([
                'name' => $faker->safeColorName,
                'description' => $faker->paragraph,
                'price' => $faker->randomFloat($nbMaxDecimals = 2, $min = 0, $max = 100),
            ]);
        }
    }
}
