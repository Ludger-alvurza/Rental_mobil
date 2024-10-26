<?php

namespace Database\Seeders;

use App\Models\Mobil;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as FakerFactory;

class MobilSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = FakerFactory::create('id_ID');

        Mobil::create([
            'no_plat' => $faker->numerify('#####'),
            'name' => 'Beat',
            'type' => 'Honda',
            'year' => '2021',
            'price_per_day' => 35000,
            'denda' => 5000,
            'availability' => 1,
        ]);

        Mobil::create([
            'no_plat' => $faker->numerify('#####'),
            'name' => 'KLX',
            'type' => 'Kawasaki',
            'year' => '2021',
            'price_per_day' => 35000,
            'denda' => 5000,
            'availability' => 1,
        ]);

        Mobil::create([
            'no_plat' => $faker->numerify('#####'),
            'name' => 'R15',
            'type' => 'Yamaha',
            'year' => '2021',
            'price_per_day' => 35000,
            'denda' => 5000,
            'availability' => 1,
        ]);
    }
}
