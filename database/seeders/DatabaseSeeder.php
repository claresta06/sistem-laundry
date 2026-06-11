<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'claresta aristawati ',
            'email' => 'clarestaaristawati@gmail.com',
            'password' => Hash::make('claresta12345'),
            'email_verified_at' => now(),
            'role' => 'admin',
        ]);

        User::factory()->create([
            'name' => 'Samuel Leonardo',
            'email' => 'samuel@laundry.com',
            'password' => Hash::make('samuel12345'),
            'email_verified_at' => now(),
            'role' => 'pelanggan',
        ]);
    }
}
