<?php

namespace Database\Seeders;

use App\Models\School;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::firstOrCreate(['name' => 'super_admin']);
        Role::firstOrCreate(['name' => 'admin_sekolah']);
        Role::firstOrCreate(['name' => 'guru']);
        Role::firstOrCreate(['name' => 'siswa']);

        $school = School::firstOrCreate([
            'slug' => 'sekolah-demo',
        ], [
            'name' => 'EduPlay Demo School',
            'domain' => 'demo.eduplay.test',
            'address' => 'Jl. Pendidikan No. 1, Jakarta',
            'quota_students' => 1000,
            'is_active' => true,
        ]);

        $admin = User::factory()->create([
            'name' => 'Super Admin',
            'email' => 'admin@eduplay.test',
            'password' => 'password',
            'school_id' => $school->id,
            'level' => 1,
            'total_xp' => 0,
        ]);

        $admin->assignRole('super_admin');
    }
}
