<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Loan Evaluation Configuration
    |--------------------------------------------------------------------------
    |
    | This file contains the configuration for the loan evaluation system.
    | These parameters are used to automatically evaluate loan applications.
    |
    */

    'evaluation_rules' => [
        // Minimum income multiplier (income must be X times the monthly payment)
        'min_income_multiplier' => env('LOAN_MIN_INCOME_MULTIPLIER', 1.5),
        
        // Maximum debt-to-income ratio (percentage)
        'max_debt_ratio' => env('LOAN_MAX_DEBT_RATIO', 40),
        
        // Minimum credit score for automatic approval
        'min_auto_approval_score' => env('LOAN_MIN_AUTO_APPROVAL_SCORE', 80),
        
        // Maximum amount for automatic approval without manual review
        'max_auto_approval_amount' => env('LOAN_MAX_AUTO_APPROVAL_AMOUNT', 50000),
    ],

    'interest_rates' => [
        'personal' => env('LOAN_INTEREST_PERSONAL', 18.0),
        'business' => env('LOAN_INTEREST_BUSINESS', 16.0),
        'home_improvement' => env('LOAN_INTEREST_HOME', 15.0),
        'medical' => env('LOAN_INTEREST_MEDICAL', 14.0),
        'education' => env('LOAN_INTEREST_EDUCATION', 12.0),
        'vehicle' => env('LOAN_INTEREST_VEHICLE', 13.0),
        'debt_consolidation' => env('LOAN_INTEREST_DEBT', 17.0),
        'emergency' => env('LOAN_INTEREST_EMERGENCY', 20.0),
    ],

    'loan_limits' => [
        'personal' => [
            'min' => 1000,
            'max' => 50000,
        ],
        'business' => [
            'min' => 5000,
            'max' => 100000,
        ],
        'home_improvement' => [
            'min' => 2000,
            'max' => 75000,
        ],
        'medical' => [
            'min' => 500,
            'max' => 30000,
        ],
        'education' => [
            'min' => 1000,
            'max' => 40000,
        ],
        'vehicle' => [
            'min' => 10000,
            'max' => 80000,
        ],
        'debt_consolidation' => [
            'min' => 2000,
            'max' => 60000,
        ],
        'emergency' => [
            'min' => 500,
            'max' => 25000,
        ],
    ],

    'term_options' => [
        6 => '6 meses',
        12 => '12 meses',
        18 => '18 meses',
        24 => '24 meses',
        36 => '36 meses',
        48 => '48 meses',
        60 => '60 meses',
    ],

    'document_types' => [
        'id_document' => [
            'name' => 'Documento de Identidad',
            'description' => 'DNI, Pasaporte o Carné de Extranjería',
            'required' => true,
            'max_size' => 5120, // KB
            'allowed_types' => ['pdf', 'jpg', 'jpeg', 'png'],
        ],
        'income_proof' => [
            'name' => 'Comprobante de Ingresos',
            'description' => 'Boletas de pago, constancia de trabajo o declaración de renta',
            'required' => true,
            'max_size' => 5120, // KB
            'allowed_types' => ['pdf', 'jpg', 'jpeg', 'png'],
        ],
        'address_proof' => [
            'name' => 'Comprobante de Domicilio',
            'description' => 'Recibo de servicios públicos o estado de cuenta bancario',
            'required' => true,
            'max_size' => 5120, // KB
            'allowed_types' => ['pdf', 'jpg', 'jpeg', 'png'],
        ],
    ],

    'scoring_weights' => [
        'income_ratio' => 30, // Weight for income vs payment ratio
        'debt_ratio' => 25,   // Weight for debt-to-income ratio
        'employment_stability' => 20, // Weight for employment type/stability
        'previous_loans' => 15, // Weight for previous loan history
        'age' => 10,          // Weight for age factor
    ],

    'employment_scores' => [
        'Empleado público' => 100,
        'Empleado privado' => 85,
        'Profesional independiente' => 70,
        'Empresario' => 60,
        'Trabajador independiente' => 50,
        'Estudiante' => 30,
        'Jubilado' => 40,
        'Desempleado' => 0,
    ],

    'age_scoring' => [
        'min_age' => 18,
        'max_age' => 70,
        'optimal_min' => 25,
        'optimal_max' => 55,
    ],

    'notification_settings' => [
        'send_application_received' => true,
        'send_evaluation_complete' => true,
        'send_approval_notification' => true,
        'send_rejection_notification' => true,
        'send_contract_ready' => true,
        'send_payment_reminders' => true,
        'reminder_days_before_due' => [3, 1],
        'overdue_notification_days' => [1, 7, 15, 30],
    ],
];
