<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(100)->create();

        $adminRole = new Role();
        $adminRole->name = 'admin';
        $adminRole->save();

        // Create admin user and assign 'admin' role
        $user = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'role' => 'admin',
            'password' => bcrypt('password123'),
        ]);
        $user->assignRole($adminRole);
    }
}
