<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        Product::create([
            'barcode' => $faker->numerify('#####'),
            'name' => 'permen',
            'price' => 200,
        ]);

        Product::create([
            'barcode' => $faker->numerify('#####'),
            'name' => 'sepatu',
            'price' => 400,
        ]);

        Product::create([
            'barcode' => $faker->numerify('#####'),
            'name' => 'permen karet',
            'price' => 200,
        ]);
    }
}
