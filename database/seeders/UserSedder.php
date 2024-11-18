<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UserSedder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            'name' => 'ludger',
            'email' => 'lud.gerdus.p@mail.ukrim.ac.id',
            'password' => bcrypt('12345678'), // Hash the password properly
            'dob' => '2001-02-03', // Format the date properly as a string
            'no_telepon' => '0845830843', // Enclose in quotes if it's a string
            'alamat' => 'Jl. Kebon Jeruk'
        ]);
        DB::table('users')->insert([
            'name' => 'Ludgerdus',
            'email' => 'ludgerdusl@gmail.com',
            'password' => bcrypt('12345678'), // Hash the password properly
            'dob' => '2001-02-03', // Format the date properly as a string
            'no_telepon' => '0845830843', // Enclose in quotes if it's a string
            'alamat' => 'Jl. Kebon Jeruk',
            'role' => 'superadmin'
        ]);
    }
}
