<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear usuario administrador por defecto
        User::create([
            'name' => 'Administrador Sistema',
            'email' => 'admin@prestamospro.com',
            'phone' => '+1234567890',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);

        $this->command->info('Usuario administrador creado exitosamente:');
        $this->command->info('Email: admin@prestamospro.com');
        $this->command->info('Password: admin123');
    }
}