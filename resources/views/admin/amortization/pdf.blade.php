<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tabla de Amortización - Préstamo #{{ $loan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 24px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 5px;
        }
        
        .document-title {
            font-size: 18px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        
        .loan-info {
            background-color: #f8fafc;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .info-grid {
            display: table;
            width: 100%;
            margin-bottom: 15px;
        }
        
        .info-row {
            display: table-row;
        }
        
        .info-cell {
            display: table-cell;
            padding: 5px 10px;
            width: 25%;
            vertical-align: top;
        }
        
        .info-label {
            font-weight: bold;
            color: #4b5563;
        }
        
        .info-value {
            color: #1f2937;
        }
        
        .amortization-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        .amortization-table th,
        .amortization-table td {
            border: 1px solid #d1d5db;
            padding: 8px;
            text-align: right;
        }
        
        .amortization-table th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .amortization-table .period-col {
            text-align: center;
        }
        
        .amortization-table .date-col {
            text-align: center;
        }
        
        .status-paid {
            background-color: #d1fae5;
            color: #065f46;
        }
        
        .status-pending {
            background-color: #fef3c7;
            color: #92400e;
        }
        
        .status-partial {
            background-color: #dbeafe;
            color: #1e40af;
        }
        
        .status-overdue {
            background-color: #fee2e2;
            color: #991b1b;
        }
        
        .totals-row {
            background-color: #f3f4f6;
            font-weight: bold;
        }
        
        .summary {
            margin-top: 20px;
            padding: 15px;
            background-color: #f8fafc;
            border-radius: 5px;
        }
        
        .summary-grid {
            display: table;
            width: 100%;
        }
        
        .summary-row {
            display: table-row;
        }
        
        .summary-cell {
            display: table-cell;
            padding: 5px 10px;
            width: 33.33%;
        }
        
        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #d1d5db;
            padding-top: 15px;
        }
        
        .page-break {
            page-break-before: always;
        }
    </style>
</head>
<body>
    <!-- Header -->
    <div class="header">
        <div class="company-name">PréstamosPro</div>
        <div class="document-title">TABLA DE AMORTIZACIÓN</div>
        <div>Préstamo #{{ $loan->id }}</div>
        <div>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <!-- Loan Information -->
    <div class="loan-info">
        <h3 style="margin-top: 0; color: #2563eb;">Información del Préstamo</h3>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Cliente:</div>
                    <div class="info-value">{{ $loan->client->user->name }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Email:</div>
                    <div class="info-value">{{ $loan->client->user->email }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Teléfono:</div>
                    <div class="info-value">{{ $loan->client->phone ?? 'N/A' }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Documento:</div>
                    <div class="info-value">{{ $loan->client->document_number ?? 'N/A' }}</div>
                </div>
            </div>
        </div>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Monto del Préstamo:</div>
                    <div class="info-value">${{ number_format($loan->amount, 2) }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Tasa de Interés:</div>
                    <div class="info-value">{{ $loan->interest_rate }}% anual</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Plazo:</div>
                    <div class="info-value">{{ $loan->term_months }} meses</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Cuota Mensual:</div>
                    <div class="info-value">${{ number_format($loan->monthly_fee, 2) }}</div>
                </div>
            </div>
        </div>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Fecha de Inicio:</div>
                    <div class="info-value">{{ $loan->start_date ? $loan->start_date->format('d/m/Y') : 'N/A' }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Fecha de Fin:</div>
                    <div class="info-value">{{ $loan->end_date ? $loan->end_date->format('d/m/Y') : 'N/A' }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">{{ ucfirst($loan->status) }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Total a Pagar:</div>
                    <div class="info-value">${{ number_format($loan->total_amount, 2) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Table -->
    <table class="amortization-table">
        <thead>
            <tr>
                <th style="width: 5%;">#</th>
                <th style="width: 10%;">Fecha Venc.</th>
                <th style="width: 12%;">Saldo Inicial</th>
                <th style="width: 12%;">Cuota</th>
                <th style="width: 12%;">Capital</th>
                <th style="width: 12%;">Interés</th>
                <th style="width: 12%;">Saldo Final</th>
                <th style="width: 10%;">Estado</th>
                <th style="width: 12%;">Monto Pagado</th>
                <th style="width: 10%;">Fecha Pago</th>
            </tr>
        </thead>
        <tbody>
            @foreach($loan->amortizationSchedule as $payment)
            @php
                $status = $payment->isOverdue() ? 'overdue' : $payment->status;
                $statusText = [
                    'pending' => 'Pendiente',
                    'paid' => 'Pagado',
                    'partial' => 'Parcial',
                    'overdue' => 'Vencido'
                ][$status];
                $statusClass = 'status-' . $status;
            @endphp
            <tr>
                <td class="period-col">{{ $payment->period_number }}</td>
                <td class="date-col">{{ $payment->due_date->format('d/m/Y') }}</td>
                <td>${{ number_format($payment->beginning_balance, 2) }}</td>
                <td>${{ number_format($payment->payment_amount, 2) }}</td>
                <td>${{ number_format($payment->principal_payment, 2) }}</td>
                <td>${{ number_format($payment->interest_payment, 2) }}</td>
                <td>${{ number_format($payment->ending_balance, 2) }}</td>
                <td class="{{ $statusClass }}" style="text-align: center;">{{ $statusText }}</td>
                <td>${{ number_format($payment->amount_paid, 2) }}</td>
                <td class="date-col">{{ $payment->payment_date ? $payment->payment_date->format('d/m/Y') : '-' }}</td>
            </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr class="totals-row">
                <td colspan="3" style="text-align: right; font-weight: bold;">TOTALES:</td>
                <td>${{ number_format($loan->amortizationSchedule->sum('payment_amount'), 2) }}</td>
                <td>${{ number_format($loan->amortizationSchedule->sum('principal_payment'), 2) }}</td>
                <td>${{ number_format($loan->amortizationSchedule->sum('interest_payment'), 2) }}</td>
                <td colspan="2"></td>
                <td>${{ number_format($loan->amortizationSchedule->sum('amount_paid'), 2) }}</td>
                <td></td>
            </tr>
        </tfoot>
    </table>

    <!-- Summary -->
    <div class="summary">
        <h3 style="margin-top: 0; color: #2563eb;">Resumen del Préstamo</h3>
        
        @php
            $totalPaid = $loan->amortizationSchedule->sum('amount_paid');
            $totalInterest = $loan->amortizationSchedule->sum('interest_payment');
            $remainingBalance = $loan->amortizationSchedule->sum('payment_amount') - $totalPaid;
            $paidPayments = $loan->amortizationSchedule->where('status', 'paid')->count();
            $pendingPayments = $loan->amortizationSchedule->where('status', 'pending')->count();
            $overduePayments = $loan->amortizationSchedule->filter(function($payment) {
                return $payment->isOverdue();
            })->count();
        @endphp
        
        <div class="summary-grid">
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="info-label">Total Pagado:</div>
                    <div class="info-value">${{ number_format($totalPaid, 2) }}</div>
                </div>
                <div class="summary-cell">
                    <div class="info-label">Saldo Pendiente:</div>
                    <div class="info-value">${{ number_format($remainingBalance, 2) }}</div>
                </div>
                <div class="summary-cell">
                    <div class="info-label">Total Intereses:</div>
                    <div class="info-value">${{ number_format($totalInterest, 2) }}</div>
                </div>
            </div>
            <div class="summary-row">
                <div class="summary-cell">
                    <div class="info-label">Cuotas Pagadas:</div>
                    <div class="info-value">{{ $paidPayments }} de {{ $loan->term_months }}</div>
                </div>
                <div class="summary-cell">
                    <div class="info-label">Cuotas Pendientes:</div>
                    <div class="info-value">{{ $pendingPayments }}</div>
                </div>
                <div class="summary-cell">
                    <div class="info-label">Cuotas Vencidas:</div>
                    <div class="info-value">{{ $overduePayments }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Este documento fue generado automáticamente por el sistema PréstamosPro</p>
        <p>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }} | Préstamo #{{ $loan->id }}</p>
    </div>
</body>
</html>
