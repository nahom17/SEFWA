<?php

namespace Database\Seeders;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        User::create([
    'name' => 'Erifootball',
    'email' => 'Eri@football.com',
    'password' => bcrypt('Eri@2025'),
    'role' => 'admin',
]);

    User::create([
        'name' => 'User',
    'email' => 'user@nahomapp.com',
    'password' => bcrypt('1234'),
    'role' => 'user',
    ]);


        $this->call([
            ClubSeeder::class,
            StandingSeeder::class,
        ]);

    }
}
