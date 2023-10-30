<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory(5)->create();
        \App\Models\Project::factory(5)->create();

        // \App\Models\User::factory()->create([
        //     'name' => fake()->name(),
        //     'email' => 'admin@admin.com',
        //     'email_verified_at' => now(),
        //     'password' => 'admin',
        //     'remember_token' => Str::random(10),
        // ]);
    }
}
