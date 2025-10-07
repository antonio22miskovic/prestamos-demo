@extends('layouts.client')

@section('title', 'Detalle del Contrato')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Contrato de Préstamo</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Contrato #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($loan->status === 'approved') bg-green-100 text-green-800
                    @elseif($loan->status === 'active') bg-blue-100 text-blue-800
                    @elseif($loan->status === 'paid') bg-gray-100 text-gray-800
                    @endif">
                    @if($loan->status === 'approved') Aprobado
                    @elseif($loan->status === 'active') Activo
                    @elseif($loan->status === 'paid') Pagado
                    @endif
                </span>
                <a href="{{ route('client.contracts.index') }}" 
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Volver
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contract PDF Viewer -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Contrato de Préstamo</h3>
                </div>
                <div class="px-6 py-4">
                    @if($loan->contract)
                        <div class="bg-gray-100 dark:bg-gray-700 rounded-lg p-4 text-center">
                            <div class="mb-4">
                                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-gray-900 dark:text-white mb-2">Contrato PDF Generado</h4>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                                El contrato ha sido generado exitosamente. Puedes descargarlo o verlo en una nueva ventana.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                                <a href="{{ route('client.contracts.download', $loan->id) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Descargar PDF
                                </a>
                                <a href="{{ route('client.contracts.download', $loan->id) }}" 
                                   target="_blank"
                                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/>
                                    </svg>
                                    Ver en Nueva Ventana
                                </a>
                            </div>
                        </div>
                    @else
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-4 text-center">
                            <div class="mb-4">
                                <svg class="mx-auto h-12 w-12 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                </svg>
                            </div>
                            <h4 class="text-lg font-medium text-yellow-800 dark:text-yellow-200 mb-2">Contrato No Generado</h4>
                            <p class="text-sm text-yellow-700 dark:text-yellow-300 mb-4">
                                El contrato para este préstamo aún no ha sido generado.
                            </p>
                            <a href="#" 
                               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-yellow-600 hover:bg-yellow-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-yellow-500"
                               onclick="confirmContractGeneration('{{ route('client.contracts.generate', $loan->id) }}'); return false;">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                </svg>
                                Generar Contrato
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Contract Terms -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Términos del Contrato</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto del Préstamo</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                ${{ number_format($loan->amount, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés Anual</dt>
                            <dd class="mt-1 text-2xl font-bold text-gray-900 dark:text-white">
                                {{ number_format($loan->interest_rate, 2) }}%
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $loan->term_months }} meses
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($loan->monthly_fee, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Total a Pagar</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($loan->total_amount, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Inicio</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $loan->start_date ? \Carbon\Carbon::parse($loan->start_date)->format('d/m/Y') : 'Por definir' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Vencimiento</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $loan->end_date ? \Carbon\Carbon::parse($loan->end_date)->format('d/m/Y') : 'Por definir' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Aprobación</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $loan->approved_at ? $loan->approved_at->format('d/m/Y H:i') : 'N/A' }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Contract Document -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Documento del Contrato</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-6 text-sm text-gray-700 dark:text-gray-300 leading-relaxed">
                        <h4 class="font-bold text-lg mb-4 text-gray-900 dark:text-white">CONTRATO DE PRÉSTAMO PERSONAL</h4>
                        
                        <p class="mb-4">
                            <strong>ENTRE:</strong> Préstamos Demo (en adelante "EL PRESTAMISTA") y {{ $client->user->name }} 
                            (en adelante "EL PRESTATARIO"), se celebra el presente contrato de préstamo personal bajo los siguientes términos y condiciones:
                        </p>

                        <div class="space-y-4">
                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">PRIMERA: MONTO Y DESTINO</h5>
                                <p>EL PRESTAMISTA otorga a EL PRESTATARIO un préstamo por la suma de ${{ number_format($loan->amount, 0, ',', '.') }} 
                                ({{ ucwords(\NumberFormatter::create('es', \NumberFormatter::SPELLOUT)->format($loan->amount)) }} pesos), 
                                destinado a {{ $loan->loanApplication->purpose ?? 'uso personal' }}.</p>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">SEGUNDA: PLAZO Y FORMA DE PAGO</h5>
                                <p>El préstamo se pagará en {{ $loan->term_months }} cuotas mensuales consecutivas de 
                                ${{ number_format($loan->monthly_fee, 0, ',', '.') }} cada una, venciendo la primera cuota el 
                                {{ $loan->start_date ? \Carbon\Carbon::parse($loan->start_date)->addMonth()->format('d/m/Y') : '[FECHA A DEFINIR]' }}.</p>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">TERCERA: TASA DE INTERÉS</h5>
                                <p>El préstamo devengará una tasa de interés del {{ number_format($loan->interest_rate, 2) }}% anual, 
                                calculada sobre saldos insolutos.</p>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">CUARTA: OBLIGACIONES DEL PRESTATARIO</h5>
                                <ul class="list-disc list-inside space-y-1 ml-4">
                                    <li>Pagar puntualmente las cuotas mensuales en las fechas establecidas</li>
                                    <li>Notificar cualquier cambio en su situación financiera o datos personales</li>
                                    <li>Mantener vigente su información de contacto</li>
                                    <li>Usar el préstamo únicamente para el propósito declarado</li>
                                </ul>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">QUINTA: MORA Y PENALIDADES</h5>
                                <p>En caso de mora en el pago de cualquier cuota, se aplicará un interés moratorio del 1.5% mensual 
                                sobre el monto vencido, sin perjuicio de las demás acciones legales correspondientes.</p>
                            </div>

                            <div>
                                <h5 class="font-semibold text-gray-900 dark:text-white mb-2">SEXTA: JURISDICCIÓN</h5>
                                <p>Para todos los efectos legales derivados del presente contrato, las partes se someten a la 
                                jurisdicción de los tribunales competentes, renunciando expresamente a cualquier otro fuero.</p>
                            </div>
                        </div>

                        <div class="mt-8 pt-6 border-t border-gray-300 dark:border-gray-600">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">EL PRESTAMISTA</p>
                                    <div class="mt-8 border-t border-gray-400 pt-2">
                                        <p class="text-sm">Préstamos Demo</p>
                                        <p class="text-sm">Representante Legal</p>
                                    </div>
                                </div>
                                <div>
                                    <p class="font-semibold text-gray-900 dark:text-white">EL PRESTATARIO</p>
                                    <div class="mt-8 border-t border-gray-400 pt-2">
                                        <p class="text-sm">{{ $client->user->name }}</p>
                                        <p class="text-sm">{{ $client->document_number ?? 'C.C. [DOCUMENTO]' }}</p>
                                    </div>
                                </div>
                            </div>
                            <p class="text-center mt-6 text-sm text-gray-600 dark:text-gray-400">
                                Firmado digitalmente el {{ $loan->approved_at ? $loan->approved_at->format('d/m/Y') : '[FECHA]' }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Actions -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Acciones</h3>
                </div>
                <div class="px-6 py-4 space-y-3">
                    <a href="{{ route('client.contracts.download', $loan->id) }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar PDF
                    </a>
                    
                    <a href="{{ route('client.loans.show', $loan->id) }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Ver Estado del Préstamo
                    </a>
                    
                    <a href="{{ route('client.applications.show', $loan->loanApplication->id) }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ver Detalles de Solicitud
                    </a>
                </div>
            </div>

            <!-- Payment Summary -->
            @if($loan->status === 'active')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Resumen de Pagos</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    @php
                        $remainingBalance = $loan->remaining_balance ?? $loan->amount;
                        $paidAmount = $loan->amount - $remainingBalance;
                        $progressPercentage = $loan->amount > 0 ? ($paidAmount / $loan->amount) * 100 : 0;
                    @endphp
                    
                    <div>
                        <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-1">
                            <span>Progreso de Pago</span>
                            <span>{{ number_format($progressPercentage, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-2">
                            <div class="bg-blue-600 h-2 rounded-full" style="width: {{ $progressPercentage }}%"></div>
                        </div>
                    </div>
                    
                    <div class="grid grid-cols-2 gap-4 text-center">
                        <div>
                            <div class="text-lg font-semibold text-green-600 dark:text-green-400">
                                ${{ number_format($paidAmount, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Pagado</div>
                        </div>
                        <div>
                            <div class="text-lg font-semibold text-orange-600 dark:text-orange-400">
                                ${{ number_format($remainingBalance, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-500 dark:text-gray-400">Pendiente</div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Contract Info -->
            <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-4">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                            Información Legal
                        </h3>
                        <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                            <p>Este contrato tiene validez legal y establece los términos y condiciones de tu préstamo. 
                            Conserva una copia para tus registros.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@if(session('show_success_alert'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showContractSuccess();
    });
</script>
@endif

@if(session('contract_generated'))
<div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
    <div class="flex items-center">
        <div class="flex-shrink-0">
            <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
            </svg>
        </div>
        <div class="ml-3">
            <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                ¡Contrato Generado Exitosamente!
            </h3>
            <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                <p>El contrato ha sido generado y está listo para ver y descargar.</p>
            </div>
            <div class="mt-4">
                <div class="flex space-x-3">
                    <a href="{{ route('client.contracts.download', $loan->id) }}" 
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-green-700 bg-green-100 hover:bg-green-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 dark:bg-green-800 dark:text-green-200 dark:hover:bg-green-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar PDF
                    </a>
                    <a href="{{ route('client.applications.show', $loan->loanApplication->id) }}" 
                       class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 dark:bg-blue-800 dark:text-blue-200 dark:hover:bg-blue-700">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Ver Detalles de Solicitud
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

@if(session('show_error_alert'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        showContractError('{{ session('error') }}');
    });
</script>
@endif
@endsection
