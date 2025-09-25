<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = [
            [
                'user' => [
                    'name' => 'Juan Pérez',
                    'email' => 'juan.perez@example.com',
                    'phone' => '+51987654001',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '12345678',
                    'address' => 'Av. Lima 123, San Isidro, Lima',
                    'birthdate' => '1985-03-15',
                    'employment' => 'Ingeniero de Software',
                    'income' => 5000.00,
                    'expenses' => 2000.00,
                ]
            ],
            [
                'user' => [
                    'name' => 'Ana García',
                    'email' => 'ana.garcia@example.com',
                    'phone' => '+51987654002',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '87654321',
                    'address' => 'Jr. Cusco 456, Miraflores, Lima',
                    'birthdate' => '1990-07-22',
                    'employment' => 'Contadora',
                    'income' => 4000.00,
                    'expenses' => 1800.00,
                ]
            ],
            [
                'user' => [
                    'name' => 'Carlos Mendoza',
                    'email' => 'carlos.mendoza@example.com',
                    'phone' => '+51987654003',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '11223344',
                    'address' => 'Av. Arequipa 789, San Borja, Lima',
                    'birthdate' => '1988-11-10',
                    'employment' => 'Médico',
                    'income' => 8000.00,
                    'expenses' => 3000.00,
                ]
            ],
            [
                'user' => [
                    'name' => 'Lucía Fernández',
                    'email' => 'lucia.fernandez@example.com',
                    'phone' => '+51987654004',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '44332211',
                    'address' => 'Calle Los Olivos 321, La Molina, Lima',
                    'birthdate' => '1992-05-18',
                    'employment' => 'Diseñadora Gráfica',
                    'income' => 3500.00,
                    'expenses' => 1500.00,
                ]
            ],
            [
                'user' => [
                    'name' => 'Roberto Silva',
                    'email' => 'roberto.silva@example.com',
                    'phone' => '+51987654005',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '55667788',
                    'address' => 'Av. Javier Prado 654, Surco, Lima',
                    'birthdate' => '1983-09-25',
                    'employment' => 'Gerente de Ventas',
                    'income' => 6500.00,
                    'expenses' => 2500.00,
                ]
            ]
        ];

        foreach ($clients as $clientData) {
            $user = User::create($clientData['user']);
            
            Client::create(array_merge($clientData['client'], [
                'user_id' => $user->id
            ]));
        }

        $this->command->info('Client users created successfully!');
    }
}
