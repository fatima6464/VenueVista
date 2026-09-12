<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Equivalent of the Node.js admin-creation logic in server.js / config/database.js
        User::firstOrCreate(
            ['email' => config('venuevista.admin_email', 'admin@venue.com')],
            [
                'name' => 'Admin',
                'password' => Hash::make(config('venuevista.admin_password', 'admin123')),
                'role' => 'admin',
            ]
        );
    }
}