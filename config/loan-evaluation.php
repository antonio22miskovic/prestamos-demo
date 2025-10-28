<?php

return array (
  'evaluation_rules' => 
  array (
    'min_income_multiplier' => 1.5,
    'max_debt_ratio' => 40,
    'min_auto_approval_score' => 80,
    'max_auto_approval_amount' => 50000,
  ),
  'interest_rates' => 
  array (
    'personal' => '18',
    'business' => '16',
    'home_improvement' => '15',
    'medical' => '14',
    'education' => '12',
    'vehicle' => '13',
    'debt_consolidation' => '17',
    'emergency' => '20',
  ),
  'loan_limits' => 
  array (
    'personal' => 
    array (
      'min' => 1000,
      'max' => 50000,
    ),
    'business' => 
    array (
      'min' => 5000,
      'max' => 100000,
    ),
    'home_improvement' => 
    array (
      'min' => 2000,
      'max' => 75000,
    ),
    'medical' => 
    array (
      'min' => 500,
      'max' => 30000,
    ),
    'education' => 
    array (
      'min' => 1000,
      'max' => 40000,
    ),
    'vehicle' => 
    array (
      'min' => 10000,
      'max' => 80000,
    ),
    'debt_consolidation' => 
    array (
      'min' => 2000,
      'max' => 60000,
    ),
    'emergency' => 
    array (
      'min' => 500,
      'max' => 25000,
    ),
  ),
  'term_options' => 
  array (
    6 => '6 meses',
    12 => '12 meses',
    18 => '18 meses',
    24 => '24 meses',
    36 => '36 meses',
    48 => '48 meses',
    60 => '60 meses',
  ),
  'document_types' => 
  array (
    'id_document' => 
    array (
      'name' => 'Documento de Identidad',
      'description' => 'DNI, Pasaporte o Carné de Extranjería',
      'required' => true,
      'max_size' => 5120,
      'allowed_types' => 
      array (
        0 => 'pdf',
        1 => 'jpg',
        2 => 'jpeg',
        3 => 'png',
      ),
    ),
    'income_proof' => 
    array (
      'name' => 'Comprobante de Ingresos',
      'description' => 'Boletas de pago, constancia de trabajo o declaración de renta',
      'required' => true,
      'max_size' => 5120,
      'allowed_types' => 
      array (
        0 => 'pdf',
        1 => 'jpg',
        2 => 'jpeg',
        3 => 'png',
      ),
    ),
    'address_proof' => 
    array (
      'name' => 'Comprobante de Domicilio',
      'description' => 'Recibo de servicios públicos o estado de cuenta bancario',
      'required' => true,
      'max_size' => 5120,
      'allowed_types' => 
      array (
        0 => 'pdf',
        1 => 'jpg',
        2 => 'jpeg',
        3 => 'png',
      ),
    ),
  ),
  'scoring_weights' => 
  array (
    'income_ratio' => 30,
    'debt_ratio' => 25,
    'employment_stability' => 20,
    'previous_loans' => 15,
    'age' => 10,
  ),
  'employment_scores' => 
  array (
    'Empleado público' => 100,
    'Empleado privado' => 85,
    'Profesional independiente' => 70,
    'Empresario' => 60,
    'Trabajador independiente' => 50,
    'Estudiante' => 30,
    'Jubilado' => 40,
    'Desempleado' => 0,
  ),
  'age_scoring' => 
  array (
    'min_age' => 18,
    'max_age' => 70,
    'optimal_min' => 25,
    'optimal_max' => 55,
  ),
  'notification_settings' => 
  array (
    'send_application_received' => true,
    'send_evaluation_complete' => true,
    'send_approval_notification' => true,
    'send_rejection_notification' => true,
    'send_contract_ready' => true,
    'send_payment_reminders' => true,
    'reminder_days_before_due' => 
    array (
      0 => 3,
      1 => 1,
    ),
    'overdue_notification_days' => 
    array (
      0 => 1,
      1 => 7,
      2 => 15,
      3 => 30,
    ),
  ),
);
