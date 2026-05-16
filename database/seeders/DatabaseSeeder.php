<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Call role seeder first
        $this->call(RoleSeeder::class);

        // Create default school
        $school = School::firstOrCreate([
            'slug' => 'demo-school',
        ], [
            'name' => 'Demo School',
            'domain' => 'demo.eduplay.test',
            'address' => 'Demo address',
            'quota_students' => 1000,
            'is_active' => true,
        ]);

        // Create super admin user
        $superAdmin = User::firstOrCreate([
            'email' => 'admin@eduplay.test',
        ], [
            'name' => 'Super Admin',
            'password' => Hash::make('password'),
            'school_id' => $school->id,
            'email_verified_at' => now(),
        ]);

        $superAdmin->assignRole('super-admin');

        // Seed demo data after basic app setup
        $this->call(DemoDataSeeder::class);
    }
}
