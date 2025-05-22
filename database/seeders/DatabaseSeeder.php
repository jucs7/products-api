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
        // Generate admin user
        User::factory()->create([
            'name' => 'SuperAdmin',
            'email' => 'admin@test.com',
            'password' => Hash::make('adminpass'),
            'role' => 'admin',
        ]);
    }
}
