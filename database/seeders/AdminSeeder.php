<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin user (usuario del login)
        User::firstOrCreate(
            ['email' => 'admin@prestamos-demo.com'],
            [
                'name' => 'Administrador',
                'phone' => '+51987654321',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        // Create additional admin users
        User::create([
            'name' => 'María González',
            'email' => 'maria.gonzalez@prestamos-demo.com',
            'phone' => '+51987654322',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        User::create([
            'name' => 'Carlos Rodríguez',
            'email' => 'carlos.rodriguez@prestamos-demo.com',
            'phone' => '+51987654323',
            'role' => 'admin',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
        ]);

        $this->command->info('Admin users created successfully!');
    }
}
