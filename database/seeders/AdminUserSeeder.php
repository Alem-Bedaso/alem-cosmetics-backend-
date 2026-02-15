<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin User
        User::create([
            'name' => 'Admin User',
            'email' => 'admin@alemcosmetics.com',
            'password' => Hash::make('admin123'),
            'role_id' => 2, // Admin role
        ]);

        // Create Supplier User
        User::create([
            'name' => 'Supplier User',
            'email' => 'supplier@alemcosmetics.com',
            'password' => Hash::make('supplier123'),
            'role_id' => 3, // Supplier role
        ]);

        echo "Admin and Supplier users created successfully!\n";
        echo "Admin Login: admin@alemcosmetics.com / admin123\n";
        echo "Supplier Login: supplier@alemcosmetics.com / supplier123\n";
    }
}
