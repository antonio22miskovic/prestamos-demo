<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\Loan;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class TestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('Creando datos de prueba...');

        // Crear clientes de prueba
        $clients = [];
        for ($i = 1; $i <= 10; $i++) {
            $user = User::create([
                'name' => "Cliente Prueba {$i}",
                'email' => "cliente{$i}@test.com",
                'phone' => "+123456789{$i}",
                'password' => Hash::make('password'),
                'role' => 'client',
                'email_verified_at' => now(),
                'created_at' => Carbon::now()->subDays(rand(1, 90)),
            ]);

            $client = Client::create([
                'user_id' => $user->id,
                'document_type' => 'CC',
                'document_number' => '1000000' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'income' => rand(80000, 300000),
                'expenses' => rand(30000, 100000),
                'employment' => ['Empleado', 'Independiente', 'Empresario'][rand(0, 2)],
                'created_at' => $user->created_at,
            ]);

            $clients[] = $client;
        }

        $this->command->info('Clientes creados: ' . count($clients));

        // Crear solicitudes de préstamo
        $applications = [];
        foreach ($clients as $client) {
            // Cada cliente puede tener entre 1 y 3 solicitudes
            $numApplications = rand(1, 3);
            
            for ($j = 0; $j < $numApplications; $j++) {
                $createdAt = Carbon::parse($client->created_at)->addDays(rand(1, 30));
                $status = ['draft', 'pending', 'approved', 'rejected'][rand(0, 3)];
                
                $application = LoanApplication::create([
                    'client_id' => $client->id,
                    'amount' => [10000, 25000, 50000, 100000, 200000][rand(0, 4)],
                    'term_months' => [12, 18, 24, 36, 48][rand(0, 4)],
                    'purpose' => [
                        'Consolidación de deudas',
                        'Mejoras del hogar',
                        'Gastos médicos',
                        'Educación',
                        'Capital de trabajo',
                        'Vehículo'
                    ][rand(0, 5)],
                    'status' => $status,
                    'created_at' => $createdAt,
                    'submitted_at' => $status !== 'draft' ? $createdAt->addHours(rand(1, 24)) : null,
                    'evaluated_at' => in_array($status, ['approved', 'rejected']) ? $createdAt->addDays(rand(1, 7)) : null,
                    'evaluation_notes' => in_array($status, ['approved', 'rejected']) 
                        ? ($status === 'approved' ? 'Solicitud aprobada según criterios de evaluación.' : 'No cumple con los requisitos mínimos de ingresos.')
                        : null,
                ]);

                $applications[] = $application;

                // Si la solicitud fue aprobada, crear el préstamo
                if ($status === 'approved') {
                    $interestRate = 0.15; // 15% anual
                    $monthlyRate = $interestRate / 12;
                    $monthlyPayment = $application->amount * ($monthlyRate * pow(1 + $monthlyRate, $application->term_months)) / 
                                    (pow(1 + $monthlyRate, $application->term_months) - 1);

                    $loanStatus = ['approved', 'active', 'paid'][rand(0, 2)];
                    
                    // Calcular fechas de inicio y fin
                    $startDate = $application->evaluated_at->addDays(rand(1, 7));
                    $endDate = $startDate->copy()->addMonths($application->term_months);

                    $loan = Loan::create([
                        'client_id' => $client->id,
                        'loan_application_id' => $application->id,
                        'amount' => $application->amount,
                        'term_months' => $application->term_months,
                        'interest_rate' => $interestRate,
                        'monthly_fee' => round($monthlyPayment, 2),
                        'total_amount' => round($monthlyPayment * $application->term_months, 2),
                        'start_date' => $startDate,
                        'end_date' => $endDate,
                        'status' => $loanStatus,
                        'approved_by' => 1, // ID del admin
                        'approved_at' => $application->evaluated_at,
                        'created_at' => $application->evaluated_at,
                    ]);

                    // Generar cuotas
                    $loan->generateInstallments();

                    // Si el préstamo está activo o pagado, simular algunos pagos
                    if (in_array($loanStatus, ['active', 'paid'])) {
                        $installments = $loan->installments()->orderBy('due_date')->get();
                        $paymentCount = $loanStatus === 'paid' 
                            ? $installments->count() 
                            : rand(1, max(1, $installments->count() - 2));

                        foreach ($installments->take($paymentCount) as $installment) {
                            $installment->markAsPaid($installment->total);
                        }
                    }
                }
            }
        }

        $this->command->info('Solicitudes creadas: ' . count($applications));
        $this->command->info('Préstamos creados: ' . Loan::count());

        $this->command->info('¡Datos de prueba creados exitosamente!');
        $this->command->info('');
        $this->command->info('Usuarios de prueba:');
        $this->command->info('Admin: admin@prestamospro.com / admin123');
        $this->command->info('Clientes: cliente1@test.com hasta cliente10@test.com / password');
    }
}