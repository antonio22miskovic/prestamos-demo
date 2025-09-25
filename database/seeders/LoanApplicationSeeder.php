<?php

namespace Database\Seeders;

use App\Models\Client;
use App\Models\LoanApplication;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LoanApplicationSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $clients = Client::all();

        if ($clients->isEmpty()) {
            $this->command->warn('No clients found. Please run ClientSeeder first.');
            return;
        }

        $purposes = [
            'Préstamo personal',
            'Consolidación de deudas',
            'Mejoras del hogar',
            'Gastos médicos',
            'Educación',
            'Vehículo',
            'Negocio'
        ];

        $applications = [
            [
                'client_id' => $clients->first()->id,
                'purpose' => 'Préstamo personal',
                'amount' => 15000.00,
                'term_months' => 24,
                'has_previous_loans' => false,
                'current_step' => 4,
                'status' => 'pending',
                'evaluation_score' => 85.5,
                'evaluation_notes' => 'Cliente con buen historial crediticio y ingresos estables.',
                'submitted_at' => now()->subDays(5),
                'loan_data' => [
                    'step1' => ['purpose' => 'Préstamo personal', 'description' => 'Para gastos personales'],
                    'step2' => ['amount' => 15000, 'term_months' => 24, 'has_previous_loans' => false],
                    'step3' => ['completed' => true],
                    'step4' => ['documents_uploaded' => 3]
                ]
            ],
            [
                'client_id' => $clients->skip(1)->first()->id,
                'purpose' => 'Mejoras del hogar',
                'amount' => 25000.00,
                'term_months' => 36,
                'has_previous_loans' => true,
                'current_step' => 3,
                'status' => 'draft',
                'evaluation_score' => null,
                'evaluation_notes' => null,
                'submitted_at' => null,
                'loan_data' => [
                    'step1' => ['purpose' => 'Mejoras del hogar', 'description' => 'Renovación de cocina y baño'],
                    'step2' => ['amount' => 25000, 'term_months' => 36, 'has_previous_loans' => true],
                    'step3' => ['in_progress' => true]
                ]
            ],
            [
                'client_id' => $clients->skip(2)->first()->id,
                'purpose' => 'Consolidación de deudas',
                'amount' => 30000.00,
                'term_months' => 48,
                'has_previous_loans' => true,
                'current_step' => 4,
                'status' => 'approved',
                'evaluation_score' => 92.0,
                'evaluation_notes' => 'Excelente perfil crediticio. Cliente médico con ingresos altos y estables.',
                'submitted_at' => now()->subDays(10),
                'evaluated_at' => now()->subDays(8),
                'loan_data' => [
                    'step1' => ['purpose' => 'Consolidación de deudas', 'description' => 'Unificar deudas de tarjetas de crédito'],
                    'step2' => ['amount' => 30000, 'term_months' => 48, 'has_previous_loans' => true],
                    'step3' => ['completed' => true],
                    'step4' => ['documents_uploaded' => 3, 'verified' => true]
                ]
            ],
            [
                'client_id' => $clients->skip(3)->first()->id,
                'purpose' => 'Negocio',
                'amount' => 12000.00,
                'term_months' => 18,
                'has_previous_loans' => false,
                'current_step' => 4,
                'status' => 'rejected',
                'evaluation_score' => 45.0,
                'evaluation_notes' => 'Ingresos insuficientes para el monto solicitado.',
                'rejection_reason' => 'Los ingresos declarados no cumplen con el ratio mínimo requerido para el monto solicitado.',
                'submitted_at' => now()->subDays(15),
                'evaluated_at' => now()->subDays(12),
                'loan_data' => [
                    'step1' => ['purpose' => 'Negocio', 'description' => 'Capital de trabajo para estudio de diseño'],
                    'step2' => ['amount' => 12000, 'term_months' => 18, 'has_previous_loans' => false],
                    'step3' => ['completed' => true],
                    'step4' => ['documents_uploaded' => 3]
                ]
            ],
            [
                'client_id' => $clients->skip(4)->first()->id,
                'purpose' => 'Vehículo',
                'amount' => 40000.00,
                'term_months' => 60,
                'has_previous_loans' => false,
                'current_step' => 2,
                'status' => 'draft',
                'evaluation_score' => null,
                'evaluation_notes' => null,
                'submitted_at' => null,
                'loan_data' => [
                    'step1' => ['purpose' => 'Vehículo', 'description' => 'Compra de automóvil para trabajo'],
                    'step2' => ['amount' => 40000, 'term_months' => 60, 'has_previous_loans' => false]
                ]
            ]
        ];

        foreach ($applications as $applicationData) {
            LoanApplication::create($applicationData);
        }

        $this->command->info('Loan applications created successfully!');
    }
}
