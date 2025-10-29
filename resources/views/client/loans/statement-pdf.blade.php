<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estado de Cuenta - Préstamo #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            color: #333;
            font-size: 12px;
            line-height: 1.6;
        }
        
        .header {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 20px;
            text-align: center;
            margin-bottom: 20px;
        }
        
        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }
        
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
        }
        
        .container {
            padding: 0 20px;
        }
        
        .info-section {
            margin-bottom: 20px;
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
        }
        
        .info-section h3 {
            margin-top: 0;
            color: #667eea;
            font-size: 14px;
            border-bottom: 2px solid #667eea;
            padding-bottom: 5px;
        }
        
        .info-section p {
            margin: 5px 0;
        }
        
        .summary {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 15px;
            margin-bottom: 20px;
        }
        
        .summary-card {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            padding: 15px;
            border-radius: 8px;
            text-align: center;
        }
        
        .summary-card .label {
            font-size: 10px;
            color: #666;
            text-transform: uppercase;
            margin-bottom: 5px;
        }
        
        .summary-card .value {
            font-size: 20px;
            font-weight: bold;
            color: #333;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        
        thead th {
            background: #667eea;
            color: white;
            padding: 10px;
            text-align: left;
            font-weight: bold;
            font-size: 11px;
        }
        
        tbody td {
            padding: 8px 10px;
            border-bottom: 1px solid #ddd;
        }
        
        tbody tr:nth-child(even) {
            background: #f8f9fa;
        }
        
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        
        .status-paid {
            background: #d4edda;
            color: #155724;
        }
        
        .status-partial {
            background: #fff3cd;
            color: #856404;
        }
        
        .status-pending {
            background: #f8d7da;
            color: #721c24;
        }
        
        .footer {
            margin-top: 30px;
            padding-top: 20px;
            border-top: 2px solid #ddd;
            text-align: center;
            color: #666;
            font-size: 10px;
        }
        
        .totals {
            margin-top: 20px;
            text-align: right;
        }
        
        .totals table {
            margin-left: auto;
            max-width: 400px;
        }
        
        .totals td {
            padding: 5px 15px;
        }
        
        .totals .label {
            font-weight: bold;
        }
        
        .logo {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="logo">PrestamosPro</div>
        <h1>Estado de Cuenta del Préstamo</h1>
        <p>Generado el {{ now()->format('d/m/Y H:i:s') }}</p>
    </div>
    
    <!-- Información del Cliente y Préstamo -->
    <div class="container">
        <div class="info-section">
            <h3>Información del Cliente</h3>
            <p><strong>Nombre:</strong> {{ $client->user->name }}</p>
            <p><strong>Email:</strong> {{ $client->user->email }}</p>
            <p><strong>Número de Préstamo:</strong> #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</p>
            <p><strong>Fecha de Aprobación:</strong> {{ $loan->approved_at->format('d/m/Y') }}</p>
        </div>
        
        <!-- Resumen -->
        <div class="summary">
            <div class="summary-card">
                <div class="label">Monto Original</div>
                <div class="value">${{ number_format($loan->amount, 2, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Saldo Pendiente</div>
                <div class="value">${{ number_format($loan->remaining_balance, 2, ',', '.') }}</div>
            </div>
            <div class="summary-card">
                <div class="label">Cuota Mensual</div>
                <div class="value">${{ number_format($loan->monthly_fee, 2, ',', '.') }}</div>
            </div>
        </div>
        
        <!-- Detalles Adicionales -->
        <div class="info-section">
            <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
                <div>
                    <p><strong>Tasa de Interés:</strong> {{ number_format($loan->interest_rate, 2) }}%</p>
                    <p><strong>Plazo:</strong> {{ $loan->term_months }} meses</p>
                </div>
                <div>
                    <p><strong>Monto Total a Pagar:</strong> ${{ number_format($loan->total_amount, 2, ',', '.') }}</p>
                    <p><strong>Estado del Préstamo:</strong> {{ ucfirst($loan->status) }}</p>
                </div>
            </div>
        </div>
        
        <!-- Tabla de Amortización -->
        <div class="info-section" style="margin-top: 20px;">
            <h3>Cronograma de Pagos (Tabla de Amortización)</h3>
            <table>
                <thead>
                    <tr>
                        <th># Cuota</th>
                        <th>Fecha Vencimiento</th>
                        <th>Monto Cuota</th>
                        <th>Capital</th>
                        <th>Interés</th>
                        <th>Estado</th>
                        <th>Monto Pagado</th>
                        <th>Fecha de Pago</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($loan->installments as $installment)
                    <tr>
                        <td>{{ $installment->installment_number }}</td>
                        <td>{{ $installment->due_date->format('d/m/Y') }}</td>
                        <td>${{ number_format($installment->amount, 2, ',', '.') }}</td>
                        <td>${{ number_format($installment->principal, 2, ',', '.') }}</td>
                        <td>${{ number_format($installment->interest, 2, ',', '.') }}</td>
                        <td>
                            <span class="status-badge status-{{ $installment->status }}">
                                @if($installment->status === 'paid')
                                    Pagado
                                @elseif($installment->status === 'partial')
                                    Parcial
                                @else
                                    Pendiente
                                @endif
                            </span>
                        </td>
                        <td>
                            @if($installment->paid_amount)
                                ${{ number_format($installment->paid_amount, 2, ',', '.') }}
                            @else
                                $0.00
                            @endif
                        </td>
                        <td>
                            @if($installment->payment_date)
                                {{ $installment->payment_date->format('d/m/Y') }}
                            @else
                                -
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
            
            <!-- Totales -->
            <div class="totals">
                <table>
                    <tr>
                        <td class="label">Total de Cuotas:</td>
                        <td>{{ $loan->installments->count() }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cuotas Pagadas:</td>
                        <td>{{ $loan->installments->where('status', 'paid')->count() }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cuotas Parciales:</td>
                        <td>{{ $loan->installments->where('status', 'partial')->count() }}</td>
                    </tr>
                    <tr>
                        <td class="label">Cuotas Pendientes:</td>
                        <td>{{ $loan->installments->where('status', 'pending')->count() }}</td>
                    </tr>
                    <tr style="border-top: 2px solid #667eea;">
                        <td class="label">Total Pagado:</td>
                        <td>${{ number_format($loan->amount - $loan->remaining_balance, 2, ',', '.') }}</td>
                    </tr>
                    <tr>
                        <td class="label">Saldo Pendiente:</td>
                        <td style="color: #dc3545; font-weight: bold;">${{ number_format($loan->remaining_balance, 2, ',', '.') }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <div class="footer">
        <p><strong>PrestamosPro</strong> - Sistema de Gestión de Préstamos</p>
        <p>Este documento es una copia oficial de su estado de cuenta.</p>
        <p>Para consultas o aclaraciones, contáctenos a través de nuestros canales oficiales.</p>
    </div>
</body>
</html>

