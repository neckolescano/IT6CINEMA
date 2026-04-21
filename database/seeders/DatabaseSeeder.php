<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use App\Models\AdminProfile;
use App\Models\CustomerProfile;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // 1. Create Roles (Mandatory for User Creation)
        $adminRole = Role::create(['role_name' => 'admin']);    
        $customerRole = Role::create(['role_name' => 'customer']); 

        // 2. Create Admin User & Linked Profile
        $adminUser = User::create([
            'role_id' => $adminRole->role_id,
            'email' => 'admin@cinemaz.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        AdminProfile::create([
            'user_id' => $adminUser->user_id,
            'first_name' => 'Cinema',
            'middle_name' => 'Z',
            'last_name' => 'Administrator',
        ]);

        // 3. Create Customer User & Linked Profile
        $customerUser = User::create([
            'role_id' => $customerRole->role_id,
            'email' => 'customer@example.com',
            'password' => Hash::make('password123'),
            'is_active' => true,
        ]);

        CustomerProfile::create([
            'user_id' => $customerUser->user_id,
            'first_name' => 'John',
            'middle_name' => 'D',
            'last_name' => 'Doe',
            'gender' => 'Male',
            'date_of_birth' => '1995-01-01',
            'phone_number' => '09123456789',
        ]);
    }
}