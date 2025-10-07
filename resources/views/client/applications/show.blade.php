@extends('layouts.client')

@section('title', 'Detalle de Solicitud')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Header -->
    <div class="mb-8">
        <div class="flex items-center justify-between">
            <div>
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white">Detalle de Solicitud</h1>
                <p class="mt-2 text-gray-600 dark:text-gray-400">Solicitud #{{ $application->id }}</p>
            </div>
            <div class="flex items-center space-x-3">
                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                    @if($application->status === 'draft') bg-gray-100 text-gray-800
                    @elseif($application->status === 'pending') bg-yellow-100 text-yellow-800
                    @elseif($application->status === 'approved') bg-green-100 text-green-800
                    @elseif($application->status === 'rejected') bg-red-100 text-red-800
                    @endif">
                    @if($application->status === 'draft') Borrador
                    @elseif($application->status === 'pending') Pendiente
                    @elseif($application->status === 'approved') Aprobada
                    @elseif($application->status === 'rejected') Rechazada
                    @endif
                </span>
                <a href="{{ route('client.applications.index') }}" 
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
            <!-- Application Info -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información de la Solicitud</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Solicitado</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($application->amount, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $application->term_months }} meses
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Propósito</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->purpose ?? 'No especificado' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Solicitud</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->created_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        @if($application->submitted_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Envío</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->submitted_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        @endif
                        @if($application->evaluated_at)
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Evaluación</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->evaluated_at->format('d/m/Y H:i') }}
                            </dd>
                        </div>
                        @endif
                    </dl>
                </div>
            </div>

            <!-- Client Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Información Personal</h3>
                </div>
                <div class="px-6 py-4">
                    <dl class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->phone ?? 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Dirección</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->address ?? 'No especificada' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empleo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->employment ?? 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->company_name ?? 'No especificada' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Años de Empleo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->employment_years ?? 'No especificado' }} años</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($client->income, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gastos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($client->expenses, 0, ',', '.') }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Netos</dt>
                            <dd class="mt-1 text-sm font-semibold text-green-600 dark:text-green-400">
                                ${{ number_format($client->income - $client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Documents -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Documentos Subidos</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-4">
                        @php
                            $documentTypes = [
                                'identity' => 'Documento de Identidad',
                                'bank_statement' => 'Estado de Cuenta Bancario',
                                'employment_proof' => 'Comprobante Laboral'
                            ];
                        @endphp
                        
                        @foreach($documentTypes as $type => $name)
                            <div class="flex items-center justify-between p-4 border border-gray-200 dark:border-gray-700 rounded-lg">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0">
                                        @if(isset($documents[$type]))
                                            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                            </svg>
                                        @else
                                            <svg class="w-8 h-8 text-gray-400" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                            </svg>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">{{ $name }}</h4>
                                        @if(isset($documents[$type]))
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                {{ $documents[$type]->original_name }}
                                            </p>
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Subido el {{ $documents[$type]->uploaded_at->format('d/m/Y H:i') }} • {{ number_format($documents[$type]->file_size / 1024, 0) }} KB
                                            </p>
                                        @else
                                            <p class="text-sm text-gray-500 dark:text-gray-400">No subido</p>
                                        @endif
                                    </div>
                                </div>
                                <div class="flex items-center space-x-3">
                                    @if(isset($documents[$type]))
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                            @if($documents[$type]->status === 'pending') bg-yellow-100 text-yellow-800
                                            @elseif($documents[$type]->status === 'approved') bg-green-100 text-green-800
                                            @elseif($documents[$type]->status === 'rejected') bg-red-100 text-red-800
                                            @endif">
                                            @if($documents[$type]->status === 'pending') Pendiente
                                            @elseif($documents[$type]->status === 'approved') Aprobado
                                            @elseif($documents[$type]->status === 'rejected') Rechazado
                                            @endif
                                        </span>
                                        <a href="{{ route('client.documents.download', $documents[$type]->id) }}" 
                                           class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="w-3 h-3 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                            </svg>
                                            Descargar
                                        </a>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            Faltante
                                        </span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Evaluation Notes -->
            @if($application->evaluation_notes || $application->rejection_reason)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Notas de Evaluación</h3>
                </div>
                <div class="px-6 py-4">
                    @if($application->evaluation_notes)
                        <div class="mb-4">
                            <h4 class="text-sm font-medium text-gray-900 dark:text-white mb-2">Comentarios:</h4>
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $application->evaluation_notes }}</p>
                        </div>
                    @endif
                    @if($application->rejection_reason)
                        <div class="p-4 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded-md">
                            <h4 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Motivo de Rechazo:</h4>
                            <p class="text-sm text-red-700 dark:text-red-300">{{ $application->rejection_reason }}</p>
                        </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Resumen</h3>
                </div>
                <div class="px-6 py-4 space-y-4">
                    @if($application->amount && $application->term_months)
                        @php
                            $monthlyRate = 0.02; // 2% mensual (ejemplo)
                            $monthlyPayment = ($application->amount * $monthlyRate * pow(1 + $monthlyRate, $application->term_months)) / (pow(1 + $monthlyRate, $application->term_months) - 1);
                            $totalAmount = $monthlyPayment * $application->term_months;
                        @endphp
                        
                        <div class="text-center p-4 bg-blue-50 dark:bg-blue-900/20 rounded-lg">
                            <div class="text-2xl font-bold text-blue-600 dark:text-blue-400">
                                ${{ number_format($monthlyPayment, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-blue-600 dark:text-blue-400">Cuota Mensual Estimada</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($totalAmount, 0, ',', '.') }}
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Total a Pagar</div>
                        </div>
                    @endif
                    
                    @if($application->evaluation_score)
                        <div class="text-center">
                            <div class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $application->evaluation_score }}/100
                            </div>
                            <div class="text-sm text-gray-500 dark:text-gray-400">Puntaje de Evaluación</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Associated Loan -->
            @if($application->loan)
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Préstamo Asociado</h3>
                </div>
                <div class="px-6 py-4">
                    <div class="space-y-3">
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">ID del Préstamo:</span>
                            <span class="text-sm font-medium text-gray-900 dark:text-white">#{{ $application->loan->id }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Estado:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($application->loan->status === 'active') bg-green-100 text-green-800
                                @elseif($application->loan->status === 'paid') bg-blue-100 text-blue-800
                                @elseif($application->loan->status === 'defaulted') bg-red-100 text-red-800
                                @endif">
                                @if($application->loan->status === 'active') Activo
                                @elseif($application->loan->status === 'paid') Pagado
                                @elseif($application->loan->status === 'defaulted') En Mora
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm text-gray-500 dark:text-gray-400">Contrato:</span>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($application->loan->contract) bg-green-100 text-green-800
                                @elseif($application->loan->amortizationSchedule->count() > 0) bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800
                                @endif">
                                @if($application->loan->contract) Generado
                                @elseif($application->loan->amortizationSchedule->count() > 0) Disponible
                                @else Sin tabla de amortización
                                @endif
                            </span>
                        </div>
                        <div class="pt-3 space-y-2">
                            <a href="{{ route('client.loans.show', $application->loan->id) }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                Ver Préstamo
                            </a>
                            
                            @if($application->loan->contract)
                                <a href="{{ route('client.contracts.show', $application->loan->id) }}" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Ver Contrato
                                </a>
                            @elseif($application->loan->amortizationSchedule->count() > 0)
                                <a href="#" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                   onclick="confirmContractGeneration('{{ route('client.contracts.generate', $application->loan->id) }}'); return false;">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Generar Contrato
                                </a>
                            @else
                                <div class="w-full text-center text-sm text-gray-500 dark:text-gray-400 py-2">
                                    <svg class="w-4 h-4 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    Esperando tabla de amortización
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Actions -->
            @if($application->status === 'draft')
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Acciones</h3>
                </div>
                <div class="px-6 py-4">
                    <a href="{{ route('client.loan-application.step1') }}" 
                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Continuar Solicitud
                    </a>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
