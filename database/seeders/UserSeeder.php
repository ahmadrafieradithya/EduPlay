<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\UserXP;
use App\Models\Streak;
use App\Models\School;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get or create demo school
        $school = School::firstOrCreate(
            ['slug' => 'demo-school'],
            [
                'name' => 'Demo School',
                'domain' => 'demo.eduplay.test',
                'address' => 'Demo address',
                'quota_students' => 1000,
                'is_active' => true,
            ]
        );

        // Create Super Admin
        $superAdmin = User::updateOrCreate(
            ['email' => 'admin@eduplay.id'],
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 20,
                'total_xp' => 60000,
            ]
        );

        // Assign super-admin role
        if (!$superAdmin->hasRole('super-admin')) {
            $superAdmin->assignRole('super-admin');
        }

        // Initialize Super Admin XP and Streak
        UserXP::updateOrCreate(
            ['user_id' => $superAdmin->id],
            [
                'total_xp' => 60000,
                'level_id' => 20, // Laravel Legend
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $superAdmin->id],
            [
                'current_streak' => 365,
                'longest_streak' => 365,
                'last_activity_date' => now()->toDateString(),
            ]
        );

        // Create Teacher 1
        $teacher1 = User::updateOrCreate(
            ['email' => 'guru@eduplay.id'],
            [
                'name' => 'Guru Berpengalaman',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 18,
                'total_xp' => 42000,
            ]
        );

        if (!$teacher1->hasRole('teacher')) {
            $teacher1->assignRole('teacher');
        }

        UserXP::updateOrCreate(
            ['user_id' => $teacher1->id],
            [
                'total_xp' => 42000,
                'level_id' => 18,
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $teacher1->id],
            [
                'current_streak' => 180,
                'longest_streak' => 200,
                'last_activity_date' => now()->subDays(2)->toDateString(),
            ]
        );

        // Create Student 1 - Beginner (High enthusiasm)
        $student1 = User::updateOrCreate(
            ['email' => 'murid1@eduplay.id'],
            [
                'name' => 'Rudi Tekun',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 3,
                'total_xp' => 450,
            ]
        );

        if (!$student1->hasRole('student')) {
            $student1->assignRole('student');
        }

        UserXP::updateOrCreate(
            ['user_id' => $student1->id],
            [
                'total_xp' => 450,
                'level_id' => 3, // Pelajar Bersemangat
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $student1->id],
            [
                'current_streak' => 14,
                'longest_streak' => 21,
                'last_activity_date' => now()->toDateString(),
            ]
        );

        // Create Student 2 - Intermediate
        $student2 = User::updateOrCreate(
            ['email' => 'murid2@eduplay.id'],
            [
                'name' => 'Siti Cerdas',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 7,
                'total_xp' => 1850,
            ]
        );

        if (!$student2->hasRole('student')) {
            $student2->assignRole('student');
        }

        UserXP::updateOrCreate(
            ['user_id' => $student2->id],
            [
                'total_xp' => 1850,
                'level_id' => 7, // Expert HTML
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $student2->id],
            [
                'current_streak' => 5,
                'longest_streak' => 45,
                'last_activity_date' => now()->subDays(1)->toDateString(),
            ]
        );

        // Create Student 3 - Advanced
        $student3 = User::updateOrCreate(
            ['email' => 'murid3@eduplay.id'],
            [
                'name' => 'Budi Master',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 12,
                'total_xp' => 9500,
            ]
        );

        if (!$student3->hasRole('student')) {
            $student3->assignRole('student');
        }

        UserXP::updateOrCreate(
            ['user_id' => $student3->id],
            [
                'total_xp' => 9500,
                'level_id' => 12, // Laravel Apprentice
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $student3->id],
            [
                'current_streak' => 60,
                'longest_streak' => 90,
                'last_activity_date' => now()->toDateString(),
            ]
        );

        // Additional 2 Sample Students for demo purposes
        $student4 = User::updateOrCreate(
            ['email' => 'murid4@eduplay.id'],
            [
                'name' => 'Aya Pemula',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 2,
                'total_xp' => 150,
            ]
        );

        if (!$student4->hasRole('student')) {
            $student4->assignRole('student');
        }

        UserXP::updateOrCreate(
            ['user_id' => $student4->id],
            [
                'total_xp' => 150,
                'level_id' => 2,
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $student4->id],
            [
                'current_streak' => 3,
                'longest_streak' => 7,
                'last_activity_date' => now()->subDays(3)->toDateString(),
            ]
        );

        $student5 = User::updateOrCreate(
            ['email' => 'murid5@eduplay.id'],
            [
                'name' => 'Dian Progresif',
                'password' => Hash::make('password'),
                'school_id' => $school->id,
                'email_verified_at' => now(),
                'level' => 9,
                'total_xp' => 3600,
            ]
        );

        if (!$student5->hasRole('student')) {
            $student5->assignRole('student');
        }

        UserXP::updateOrCreate(
            ['user_id' => $student5->id],
            [
                'total_xp' => 3600,
                'level_id' => 9,
            ]
        );

        Streak::updateOrCreate(
            ['user_id' => $student5->id],
            [
                'current_streak' => 8,
                'longest_streak' => 32,
                'last_activity_date' => now()->toDateString(),
            ]
        );
    }
}
