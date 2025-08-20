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
        // Seed roles and permissions first
        $this->call(RoleSeeder::class);
        $this->call(LocationSeeder::class);

        // Create admin user
        $admin = User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
        ]);

        // Assign admin role
        $admin->assignRole('admin');

        // Create test users for other roles
        $headOfCommune = User::createOrFirst([
            'name' => 'Head of Commune',
            'email' => 'head.commune@example.com',
        ]);
        $headOfCommune->assignRole('head_of_commune');

        $subHeadOfCommune = User::createOrFirst([
            'name' => 'Sub Head of Commune',
            'email' => 'sub.commune@example.com',
        ]);
        $subHeadOfCommune->assignRole('sub_of_head_of_commune');
    }
}
