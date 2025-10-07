<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contrato de Préstamo - #{{ $loan->id }}</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            margin: 0;
            padding: 20px;
            color: #333;
            line-height: 1.6;
        }
        
        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 3px solid #2563eb;
            padding-bottom: 20px;
        }
        
        .company-name {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 10px;
        }
        
        .document-title {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 15px;
            text-transform: uppercase;
        }
        
        .contract-info {
            background-color: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border-left: 4px solid #2563eb;
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
            padding: 8px 15px;
            width: 25%;
            vertical-align: top;
            border-bottom: 1px solid #e5e7eb;
        }
        
        .info-label {
            font-weight: bold;
            color: #4b5563;
            font-size: 11px;
        }
        
        .info-value {
            color: #1f2937;
            font-size: 12px;
        }
        
        .section {
            margin-bottom: 25px;
        }
        
        .section-title {
            font-size: 16px;
            font-weight: bold;
            color: #2563eb;
            margin-bottom: 15px;
            border-bottom: 2px solid #e5e7eb;
            padding-bottom: 5px;
        }
        
        .loan-details {
            background-color: #f9fafb;
            padding: 15px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
        
        .loan-grid {
            display: table;
            width: 100%;
        }
        
        .loan-row {
            display: table-row;
        }
        
        .loan-cell {
            display: table-cell;
            padding: 5px 10px;
            width: 50%;
            vertical-align: top;
        }
        
        .loan-label {
            font-weight: bold;
            color: #374151;
        }
        
        .loan-value {
            color: #1f2937;
        }
        
        .amortization-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            font-size: 10px;
        }
        
        .amortization-table th,
        .amortization-table td {
            border: 1px solid #d1d5db;
            padding: 6px;
            text-align: right;
        }
        
        .amortization-table th {
            background-color: #2563eb;
            color: white;
            font-weight: bold;
            text-align: center;
        }
        
        .amortization-table tr:nth-child(even) {
            background-color: #f9fafb;
        }
        
        .terms-section {
            margin-top: 30px;
            padding: 20px;
            background-color: #fef3c7;
            border-radius: 8px;
            border-left: 4px solid #f59e0b;
        }
        
        .terms-title {
            font-size: 14px;
            font-weight: bold;
            color: #92400e;
            margin-bottom: 10px;
        }
        
        .terms-text {
            font-size: 11px;
            color: #78350f;
            line-height: 1.5;
        }
        
        .signature-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .signature-cell {
            display: table-cell;
            width: 50%;
            padding: 20px;
            text-align: center;
            vertical-align: top;
        }
        
        .signature-line {
            border-bottom: 1px solid #333;
            margin-bottom: 5px;
            height: 40px;
        }
        
        .signature-label {
            font-size: 11px;
            color: #6b7280;
        }
        
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 10px;
            color: #6b7280;
            border-top: 1px solid #e5e7eb;
            padding-top: 15px;
        }
        
        .highlight {
            background-color: #dbeafe;
            padding: 2px 4px;
            border-radius: 3px;
            font-weight: bold;
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
        <div class="document-title">Contrato de Préstamo Personal</div>
        <div>Contrato #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</div>
        <div>Fecha de generación: {{ now()->format('d/m/Y H:i:s') }}</div>
    </div>

    <!-- Contract Information -->
    <div class="contract-info">
        <h3 style="margin-top: 0; color: #2563eb; font-size: 16px;">Información del Contrato</h3>
        
        <div class="info-grid">
            <div class="info-row">
                <div class="info-cell">
                    <div class="info-label">Número de Contrato:</div>
                    <div class="info-value">#{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Fecha de Aprobación:</div>
                    <div class="info-value">{{ $loan->approved_at->format('d/m/Y') }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Vigencia:</div>
                    <div class="info-value">{{ $loan->start_date->format('d/m/Y') }} - {{ $loan->end_date->format('d/m/Y') }}</div>
                </div>
                <div class="info-cell">
                    <div class="info-label">Estado:</div>
                    <div class="info-value">{{ ucfirst($loan->status) }}</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Parties Information -->
    <div class="section">
        <div class="section-title">PARTES DEL CONTRATO</div>
        
        <div class="loan-details">
            <h4 style="margin-top: 0; color: #2563eb;">ACREDITANTE (PréstamosPro)</h4>
            <div class="loan-grid">
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Razón Social:</div>
                        <div class="loan-value">PréstamosPro S.A.S.</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">NIT:</div>
                        <div class="loan-value">900.123.456-7</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Dirección:</div>
                        <div class="loan-value">Calle 123 #45-67, Bogotá D.C.</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Teléfono:</div>
                        <div class="loan-value">(601) 234-5678</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Email:</div>
                        <div class="loan-value">contacto@prestamospro.com</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Sitio Web:</div>
                        <div class="loan-value">www.prestamospro.com</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="loan-details">
            <h4 style="margin-top: 0; color: #2563eb;">ACREDITADO (Cliente)</h4>
            <div class="loan-grid">
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Nombre Completo:</div>
                        <div class="loan-value">{{ $loan->client->user->name }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Email:</div>
                        <div class="loan-value">{{ $loan->client->user->email }}</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Teléfono:</div>
                        <div class="loan-value">{{ $loan->client->user->phone ?? 'No especificado' }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Documento:</div>
                        <div class="loan-value">{{ $loan->client->document_number ?? 'No especificado' }}</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Dirección:</div>
                        <div class="loan-value">{{ $loan->client->address ?? 'No especificada' }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Empleo:</div>
                        <div class="loan-value">{{ $loan->client->employment ?? 'No especificado' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loan Details -->
    <div class="section">
        <div class="section-title">CONDICIONES DEL PRÉSTAMO</div>
        
        <div class="loan-details">
            <div class="loan-grid">
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Monto del Préstamo:</div>
                        <div class="loan-value highlight">${{ number_format($loan->amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Tasa de Interés Anual:</div>
                        <div class="loan-value highlight">{{ number_format($loan->interest_rate * 100, 2) }}%</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Plazo:</div>
                        <div class="loan-value highlight">{{ $loan->term_months }} meses</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Cuota Mensual:</div>
                        <div class="loan-value highlight">${{ number_format($loan->monthly_fee, 0, ',', '.') }}</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Total a Pagar:</div>
                        <div class="loan-value highlight">${{ number_format($loan->total_amount, 0, ',', '.') }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Fecha de Inicio:</div>
                        <div class="loan-value">{{ $loan->start_date->format('d/m/Y') }}</div>
                    </div>
                </div>
                <div class="loan-row">
                    <div class="loan-cell">
                        <div class="loan-label">Fecha de Vencimiento:</div>
                        <div class="loan-value">{{ $loan->end_date->format('d/m/Y') }}</div>
                    </div>
                    <div class="loan-cell">
                        <div class="loan-label">Propósito:</div>
                        <div class="loan-value">{{ $loan->loanApplication->purpose ?? 'Uso personal' }}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Schedule -->
    <div class="section">
        <div class="section-title">TABLA DE AMORTIZACIÓN</div>
        
        <table class="amortization-table">
            <thead>
                <tr>
                    <th>Período</th>
                    <th>Fecha Vencimiento</th>
                    <th>Saldo Inicial</th>
                    <th>Cuota</th>
                    <th>Capital</th>
                    <th>Interés</th>
                    <th>Saldo Final</th>
                </tr>
            </thead>
            <tbody>
                @foreach($loan->amortizationSchedule as $schedule)
                <tr>
                    <td style="text-align: center;">{{ $schedule->period_number }}</td>
                    <td style="text-align: center;">{{ $schedule->due_date->format('d/m/Y') }}</td>
                    <td>${{ number_format($schedule->beginning_balance, 0, ',', '.') }}</td>
                    <td>${{ number_format($schedule->payment_amount, 0, ',', '.') }}</td>
                    <td>${{ number_format($schedule->principal_payment, 0, ',', '.') }}</td>
                    <td>${{ number_format($schedule->interest_payment, 0, ',', '.') }}</td>
                    <td>${{ number_format($schedule->ending_balance, 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Terms and Conditions -->
    <div class="terms-section">
        <div class="terms-title">TÉRMINOS Y CONDICIONES GENERALES</div>
        <div class="terms-text">
            <p><strong>1. OBLIGACIONES DEL ACREDITADO:</strong></p>
            <p>El acreditado se compromete a pagar puntualmente las cuotas mensuales en las fechas establecidas en la tabla de amortización. El incumplimiento en el pago generará intereses de mora del 2% mensual sobre el saldo en mora.</p>
            
            <p><strong>2. OBLIGACIONES DEL ACREDITANTE:</strong></p>
            <p>El acreditante se compromete a desembolsar el monto del préstamo una vez firmado este contrato y cumplidos todos los requisitos legales.</p>
            
            <p><strong>3. PAGOS ANTICIPADOS:</strong></p>
            <p>El acreditado podrá realizar pagos anticipados sin penalización, los cuales se aplicarán primero a intereses y luego a capital.</p>
            
            <p><strong>4. INCUMPLIMIENTO:</strong></p>
            <p>En caso de incumplimiento por más de 30 días, el acreditante podrá declarar vencido el préstamo y exigir el pago total de la deuda.</p>
            
            <p><strong>5. LEY APLICABLE:</strong></p>
            <p>Este contrato se rige por las leyes de la República de Colombia y cualquier controversia será resuelta en los tribunales competentes de Bogotá D.C.</p>
        </div>
    </div>

    <!-- Signatures -->
    <div class="signature-section">
        <div class="signature-cell">
            <div class="signature-line"></div>
            <div class="signature-label">Firma del Acreditado</div>
            <div class="signature-label">{{ $loan->client->user->name }}</div>
            <div class="signature-label">C.C. {{ $loan->client->document_number ?? 'N/A' }}</div>
        </div>
        <div class="signature-cell">
            <div class="signature-line"></div>
            <div class="signature-label">Firma del Acreditante</div>
            <div class="signature-label">PréstamosPro S.A.S.</div>
            <div class="signature-label">NIT: 900.123.456-7</div>
        </div>
    </div>

    <!-- Footer -->
    <div class="footer">
        <p>Este documento ha sido generado electrónicamente y tiene validez legal.</p>
        <p>PréstamosPro S.A.S. - Calle 123 #45-67, Bogotá D.C. - Tel: (601) 234-5678</p>
        <p>www.prestamospro.com - contacto@prestamospro.com</p>
    </div>
</body>
</html>
