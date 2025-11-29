<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class AdminUserSeeder extends Seeder
{
    public function run()
    {
        $email = env('ADMIN_EMAIL');

        // Prevent creating duplicates
        if (User::where('email', $email)->exists()) {
            $this->command->info("Admin already exists: {$email}");
            return;
        }

        User::create([
            'name' => env('ADMIN_NAME', 'SuperAdmin'),
            'email' => $email,
            'password' => bcrypt(env('ADMIN_PASSWORD')),
            'role' => 'admin',
        ]);

        $this->command->info("✅ Admin account created successfully!");
    }
}

