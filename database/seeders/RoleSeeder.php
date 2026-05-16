<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create permissions
        $permissions = [
            'view dashboard',
            'manage schools',
            'manage users',
            'manage courses',
            'manage lessons',
            'manage quizzes',
            'manage games',
            'manage classrooms',
            'view reports',
            'manage settings',
            'impersonate users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'super-admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $schoolAdmin = Role::firstOrCreate(['name' => 'school-admin']);
        $schoolAdmin->givePermissionTo([
            'view dashboard',
            'manage users',
            'manage courses',
            'manage lessons',
            'manage quizzes',
            'manage games',
            'manage classrooms',
            'view reports',
            'manage settings',
        ]);

        $teacher = Role::firstOrCreate(['name' => 'teacher']);
        $teacher->givePermissionTo([
            'view dashboard',
            'manage courses',
            'manage lessons',
            'manage quizzes',
            'manage games',
            'manage classrooms',
            'view reports',
        ]);

        $student = Role::firstOrCreate(['name' => 'student']);
        $student->givePermissionTo([
            'view dashboard',
        ]);
    }
}