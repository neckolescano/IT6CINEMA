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
        $adminRole = Role::create(['role_name' => 'admin']);    
        $customerRole = Role::create(['role_name' => 'customer']); 

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