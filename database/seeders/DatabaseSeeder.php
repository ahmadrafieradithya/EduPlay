<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Step 1: Create roles and permissions
        $this->call(RoleSeeder::class);

        // Step 2: Seed levels (must be first for users to reference)
        $this->call(LevelSeeder::class);

        // Step 3: Create users with roles, XP, and streaks
        $this->call(UserSeeder::class);

        // Step 4: Create learning paths with topics and lessons
        $this->call(LearningPathSeeder::class);

        // Step 5: Create games with levels and content
        $this->call(GameSeeder::class);

        // Step 6: Create badges
        $this->call(BadgeSeeder::class);

        // Optional: Seed additional demo data if exists
        if (class_exists(DemoDataSeeder::class)) {
            $this->call(DemoDataSeeder::class);
        }
    }
}
