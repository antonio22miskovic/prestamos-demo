<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Client;
use App\Models\LoanApplication;
use App\Models\Loan;
use App\Models\AmortizationSchedule;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class RobustTestDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->command->info('🌱 Creando datos de prueba robustos...');

        // 1. Asegurar usuario admin del login
        $admin = $this->ensureAdminUser();
        
        // 2. Asegurar usuario cliente del login con préstamo completo
        $clientUser = $this->ensureClientUserWithLoan();
        
        // 3. Crear algunos clientes adicionales con préstamos
        $this->createAdditionalClients();

        $this->command->info('✅ Datos de prueba creados exitosamente!');
        $this->command->info('');
        $this->command->info('📋 Usuarios de prueba:');
        $this->command->info('   👤 Admin: admin@prestamos-demo.com / admin123');
        $this->command->info('   👤 Cliente: client@prestamos-demo.com / client123');
    }

    /**
     * Asegurar que el usuario admin del login existe
     */
    private function ensureAdminUser(): User
    {
        $admin = User::firstOrCreate(
            ['email' => 'admin@prestamos-demo.com'],
            [
                'name' => 'Administrador',
                'phone' => '+51987654321',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('   ✅ Usuario admin verificado');
        return $admin;
    }

    /**
     * Asegurar que el usuario cliente del login existe con préstamo completo
     */
    private function ensureClientUserWithLoan(): User
    {
        // Crear o actualizar usuario cliente
        $clientUser = User::firstOrCreate(
            ['email' => 'client@prestamos-demo.com'],
            [
                'name' => 'Cliente Prueba',
                'phone' => '+51987654320',
                'role' => 'client',
                'password' => Hash::make('client123'),
                'email_verified_at' => now(),
            ]
        );

        // Crear o actualizar cliente
        $client = Client::firstOrCreate(
            ['user_id' => $clientUser->id],
            [
                'document_type' => 'dni',
                'document_number' => '12345678',
                'address' => 'Av. Ejemplo 123, Lima',
                'birthdate' => '1990-01-15',
                'employment' => 'Desarrollador de Software',
                'income' => 5000.00,
                'expenses' => 2000.00,
                'employment_years' => 5,
                'company_name' => 'Tech Solutions S.A.C.',
            ]
        );

        $this->command->info('   ✅ Usuario cliente verificado');

        // Verificar si ya tiene un préstamo activo
        $existingLoan = $client->loans()
            ->where('status', 'active')
            ->first();

        if ($existingLoan) {
            $this->command->info('   ℹ️  El cliente ya tiene un préstamo, actualizando...');
            $loan = $existingLoan;
        } else {
            // Crear solicitud de préstamo
            $application = LoanApplication::create([
                'client_id' => $client->id,
                'loan_data' => [
                    'step1' => [
                        'purpose' => 'Expansión de negocio',
                        'monthly_income' => 5000,
                        'monthly_expenses' => 2000,
                    ],
                    'step2' => [
                        'amount' => 12000,
                        'term_months' => 18,
                        'has_previous_loans' => false,
                    ],
                    'step3' => [
                        'documents_uploaded' => true,
                    ],
                    'step4' => [
                        'review_complete' => true,
                    ],
                ],
                'current_step' => 4,
                'status' => 'approved',
                'purpose' => 'Expansión de negocio',
                'amount' => 12000,
                'term_months' => 18,
                'has_previous_loans' => false,
                'evaluation_score' => 85.5,
                'evaluation_notes' => 'Cliente con buen perfil crediticio',
                'submitted_at' => now()->subDays(30),
                'evaluated_at' => now()->subDays(28),
            ]);

            // Crear préstamo aprobado
            $startDate = now()->subMonths(2);
            $endDate = $startDate->copy()->addMonths(18);
            
            $loan = Loan::create([
                'client_id' => $client->id,
                'loan_application_id' => $application->id,
                'amount' => 12000.00,
                'interest_rate' => 12.00, // 12% anual
                'term_months' => 18,
                'start_date' => $startDate,
                'end_date' => $endDate,
                'status' => 'active',
                'monthly_fee' => 748.62,
                'total_amount' => 13475.16,
                'approval_note' => 'Aprobado según evaluación crediticia',
                'approved_at' => now()->subDays(28),
                'approved_by' => User::where('role', 'admin')->first()->id ?? 1,
            ]);

            $this->command->info('   ✅ Préstamo creado');
        }

        // Generar tabla de amortización si no existe
        if (!$loan->amortizationSchedule()->exists()) {
            $loan->generateAmortizationSchedule();
            $this->command->info('   ✅ Tabla de amortización generada');
        }

        // Aplicar algunos pagos (algunos pagados, otros pendientes)
        $this->applyPaymentsToLoan($loan);

        // Recargar el préstamo con sus relaciones
        $loan->refresh();
        $loan->load('contract');

        // Crear contrato si no existe
        if (!$loan->contract) {
            try {
                // Cargar todas las relaciones necesarias
                $loan->load([
                    'client.user',
                    'loanApplication',
                    'amortizationSchedule' => function($query) {
                        $query->orderBy('period_number');
                    }
                ]);
                
                $contractService = app(ContractService::class);
                $contract = $contractService->generateContract($loan);
                
                // Firmar el contrato
                $contract->sign([
                    'signature_method' => 'digital',
                    'timestamp' => now()->toIso8601String(),
                    'browser' => 'Seeder',
                    'device' => 'Testing Environment',
                ], '127.0.0.1');
                
                $this->command->info('   ✅ Contrato creado y firmado');
            } catch (\Exception $e) {
                $this->command->warn('   ⚠️  No se pudo generar el contrato: ' . $e->getMessage());
                $this->command->warn('   ⚠️  Esto es normal si faltan dependencias de PDF. El contrato se puede generar después desde la UI.');
            }
        } else {
            // Asegurar que el contrato esté firmado
            if (!$loan->contract->isSigned()) {
                $loan->contract->sign([
                    'signature_method' => 'digital',
                    'timestamp' => now()->toIso8601String(),
                    'browser' => 'Seeder',
                    'device' => 'Testing Environment',
                ], '127.0.0.1');
                $this->command->info('   ✅ Contrato firmado');
            } else {
                $this->command->info('   ✅ Contrato ya existe y está firmado');
            }
        }

        return $clientUser;
    }

    /**
     * Aplicar pagos al préstamo (algunos pagados, otros pendientes)
     */
    private function applyPaymentsToLoan(Loan $loan): void
    {
        $schedules = $loan->amortizationSchedule()
            ->orderBy('period_number')
            ->get();

        $paidCount = 0;
        $pendingCount = 0;

        foreach ($schedules as $index => $schedule) {
            // Pagar las primeras 3 cuotas (si existen)
            if ($index < 3 && $schedule->status === 'pending') {
                $schedule->status = 'paid';
                $schedule->amount_paid = $schedule->payment_amount;
                $schedule->payment_date = $schedule->due_date->copy()->subDays(rand(0, 5));
                $schedule->notes = 'Pago realizado exitosamente';
                $schedule->save();
                $paidCount++;
            }
        }

        // Actualizar status del préstamo si todas las cuotas están pagadas
        $pendingSchedules = $loan->amortizationSchedule()
            ->where('status', '!=', 'paid')
            ->count();

        if ($pendingSchedules == 0) {
            $loan->status = 'paid';
            $loan->save();
        }

        $pendingCount = $loan->amortizationSchedule()->where('status', '!=', 'paid')->count();

        $this->command->info("   ✅ Pagos aplicados: {$paidCount} cuotas pagadas, {$pendingCount} cuotas pendientes");
    }

    /**
     * Crear clientes adicionales con diferentes estados
     */
    private function createAdditionalClients(): void
    {
        $additionalClients = [
            [
                'user' => [
                    'name' => 'María González',
                    'email' => 'maria.gonzalez@prestamos-demo.com',
                    'phone' => '+51987654011',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '87654321',
                    'address' => 'Jr. Los Rosales 456, Miraflores',
                    'birthdate' => '1988-05-20',
                    'employment' => 'Contadora Pública',
                    'income' => 4500.00,
                    'expenses' => 1800.00,
                    'employment_years' => 7,
                    'company_name' => 'Contadores Asociados',
                ],
                'loan' => [
                    'amount' => 8000.00,
                    'interest_rate' => 10.5,
                    'term_months' => 12,
                    'status' => 'active',
                ],
            ],
            [
                'user' => [
                    'name' => 'Carlos Mendoza',
                    'email' => 'carlos.mendoza@prestamos-demo.com',
                    'phone' => '+51987654012',
                    'role' => 'client',
                    'password' => Hash::make('client123'),
                    'email_verified_at' => now(),
                ],
                'client' => [
                    'document_type' => 'dni',
                    'document_number' => '11223344',
                    'address' => 'Av. Principal 789',
                    'birthdate' => '1985-11-10',
                    'employment' => 'Médico',
                    'income' => 8000.00,
                    'expenses' => 3000.00,
                    'employment_years' => 10,
                    'company_name' => 'Clínica Privada',
                ],
                'loan' => [
                    'amount' => 15000.00,
                    'interest_rate' => 9.5,
                    'term_months' => 24,
                    'status' => 'active',
                ],
            ],
        ];

        foreach ($additionalClients as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['user']['email']],
                $data['user']
            );

            $client = Client::firstOrCreate(
                ['user_id' => $user->id],
                $data['client']
            );

            // Crear préstamo si no existe
            $existingLoan = $client->loans()->where('status', 'active')->first();
            
            if (!$existingLoan) {
                $startDate = now()->subMonths(1);
                $endDate = $startDate->copy()->addMonths($data['loan']['term_months']);
                
                // Calcular cuota mensual aproximada (método francés simplificado)
                $monthlyRate = ($data['loan']['interest_rate'] / 12) / 100;
                $monthlyPayment = $data['loan']['amount'] * ($monthlyRate * pow(1 + $monthlyRate, $data['loan']['term_months'])) / (pow(1 + $monthlyRate, $data['loan']['term_months']) - 1);
                
                $loan = Loan::create([
                    'client_id' => $client->id,
                    'amount' => $data['loan']['amount'],
                    'interest_rate' => $data['loan']['interest_rate'],
                    'term_months' => $data['loan']['term_months'],
                    'start_date' => $startDate,
                    'end_date' => $endDate,
                    'status' => $data['loan']['status'],
                    'monthly_fee' => round($monthlyPayment, 2),
                    'total_amount' => round($monthlyPayment * $data['loan']['term_months'], 2),
                    'approved_at' => now()->subDays(25),
                    'approved_by' => User::where('role', 'admin')->first()->id ?? 1,
                ]);

                // Generar tabla de amortización
                $loan->generateAmortizationSchedule();
                
                // Aplicar algunos pagos
                $this->applyPaymentsToLoan($loan);
            }
        }

        $this->command->info('   ✅ Clientes adicionales creados');
    }
}

