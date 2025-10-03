<?php

namespace Database\Seeders;

use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password'),
            'role' => 0,
        ]);


        User::create([
            'name' => 'Client',
            'email' => 'client@gmail.com',
            'password' => Hash::make('password'),
            'role' => 1,
        ]);

        User::factory(5)->create([
            'role' => 1, // forcer client
        ]);
    }
}
