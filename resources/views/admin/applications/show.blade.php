@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
            <a href="{{ route('admin.applications.index') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                <span>Solicitudes</span>
            </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400">Solicitud #{{ $application->id }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Detalle de Solicitud</h1>
        </div>
        <div class="mt-4 sm:mt-0">
            @php
                $statusClasses = [
                    'draft' => 'bg-gray-100 text-gray-800',
                    'pending' => 'bg-yellow-100 text-yellow-800',
                    'approved' => 'bg-green-100 text-green-800',
                    'rejected' => 'bg-red-100 text-red-800',
                ];
                $statusLabels = [
                    'draft' => 'Borrador',
                    'pending' => 'Pendiente',
                    'approved' => 'Aprobada',
                    'rejected' => 'Rechazada',
                ];
            @endphp
            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$application->status] ?? 'bg-gray-100 text-gray-800' }}">
                {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
            </span>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Application Details -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white dark:text-white mb-4">Detalles del Préstamo</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Solicitado</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                ${{ number_format($application->amount, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->term_months }} meses</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Pago Mensual Estimado</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                ${{ number_format($monthlyPayment, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Propósito</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->purpose ?: 'No especificado' }}</dd>
                        </div>
                        <div class="sm:col-span-2">
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Solicitud</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->created_at->format('d/m/Y H:i') }}
                                ({{ $application->created_at->diffForHumans() }})
                            </dd>
                        </div>
                        @if($application->submitted_at)
                            <div class="sm:col-span-2">
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Envío</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ $application->submitted_at->format('d/m/Y H:i') }}
                                </dd>
                            </div>
                        @endif
                        @if($application->evaluated_at)
                            <div class="sm:col-span-2">
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
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Información del Cliente</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->client->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->client->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->client->user->phone ?: 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documento</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->client->document_type ?: 'No especificado' }}
                                {{ $application->client->document_number ?: '' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                ${{ number_format($application->client->income, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gastos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                ${{ number_format($application->client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacidad de Pago</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                ${{ number_format($application->client->income - $application->client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Situación Laboral</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $application->client->employment ?: 'No especificado' }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Documents -->
            @if($application->documents->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Documentos Adjuntos</h3>
                        <div class="space-y-3">
                            @foreach($application->documents as $document)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div class="flex items-center space-x-3">
                                        <div class="flex-shrink-0">
                                            <svg class="h-8 w-8 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                        </div>
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">
                                                {{ $document->original_name }}
                                            </p>
                                            <p class="text-sm text-gray-500">
                                                {{ ucfirst(str_replace('_', ' ', $document->document_type)) }} • 
                                                {{ $document->created_at->format('d/m/Y') }} •
                                                {{ number_format($document->file_size / 1024, 0) }} KB
                                            </p>
                                        </div>
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.applications.download-document', [$application, $document]) }}" 
                                           class="inline-flex items-center px-3 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm leading-4 font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                            <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                            </svg>
                                            Descargar
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Evaluation Notes -->
            @if($application->evaluation_notes)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Notas de Evaluación</h3>
                        <div class="bg-gray-50 dark:bg-gray-700 rounded-md p-4">
                            <p class="text-sm text-gray-700 dark:text-gray-300">{{ $application->evaluation_notes }}</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Actions -->
            @if($application->status === 'pending')
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Acciones</h3>
                        <div class="space-y-3">
                            <!-- Approve Button -->
                            <button type="button" 
                                    onclick="openApprovalModal()"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Aprobar Solicitud
                            </button>

                            <!-- Reject Button -->
                            <button type="button" 
                                    onclick="openRejectionModal()"
                                    class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md shadow-sm text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                                Rechazar Solicitud
                            </button>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Loan Information (if approved) -->
            @if($application->loan)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Préstamo Asociado</h3>
                        <dl class="space-y-3">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">ID del Préstamo</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">#{{ $application->loan->id }}</dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Aprobado</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">
                                    ${{ number_format($application->loan->amount, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                                <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                    {{ number_format($application->loan->interest_rate * 100, 2) }}% anual
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual</dt>
                                <dd class="mt-1 text-sm text-gray-900 font-semibold">
                                    ${{ number_format($application->loan->monthly_fee, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</dt>
                                <dd class="mt-1">
                                    @php
                                        $statusClasses = [
                                            'approved' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                            'active' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                            'paid' => 'bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300',
                                            'defaulted' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                        ];
                                    @endphp
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$application->loan->status] ?? 'bg-green-100 text-green-800' }}">
                                        {{ ucfirst($application->loan->status) }}
                                    </span>
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Contrato</dt>
                                <dd class="mt-1">
                                    <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full
                                        @if($application->loan->contract) bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300
                                        @elseif($application->loan->amortizationSchedule->count() > 0) bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300
                                        @else bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-300
                                        @endif">
                                        @if($application->loan->contract) Generado
                                        @elseif($application->loan->amortizationSchedule->count() > 0) Disponible
                                        @else Sin tabla de amortización
                                        @endif
                                    </span>
                                </dd>
                            </div>
                        </dl>
                        
                        <!-- Action Buttons -->
                        <div class="mt-6 pt-4 border-t border-gray-200 dark:border-gray-700 space-y-3">
                            <a href="{{ route('admin.amortization.show', $application->loan) }}" 
                               class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2h2a2 2 0 002-2z"></path>
                                </svg>
                                Ver Tabla de Amortización
                            </a>
                            
                            @if($application->loan->contract)
                                <div class="space-y-2">
                                    <div class="w-full text-center text-sm text-green-600 dark:text-green-400 py-2 bg-green-50 dark:bg-green-900/20 rounded-md">
                                        <svg class="h-4 w-4 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Contrato Generado
                                    </div>
                                    <a href="{{ route('admin.contracts.show', $application->loan->id) }}" 
                                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                        Ver Contrato
                                    </a>
                                    <a href="{{ route('admin.contracts.download', $application->loan->id) }}" 
                                       class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                        </svg>
                                        Descargar PDF
                                    </a>
                                </div>
                            @elseif($application->loan->amortizationSchedule->count() > 0)
                                <a href="#" 
                                   class="w-full inline-flex justify-center items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500"
                                   onclick="confirmContractGeneration('{{ route('admin.contracts.generate', $application->loan->id) }}'); return false;">
                                    <svg class="h-4 w-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Generar Contrato
                                </a>
                            @else
                                <div class="w-full text-center text-sm text-gray-500 dark:text-gray-400 py-2">
                                    <svg class="h-4 w-4 mx-auto mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L3.732 16.5c-.77.833.192 2.5 1.732 2.5z"/>
                                    </svg>
                                    Esperando tabla de amortización
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            @endif

            <!-- Quick Stats -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Análisis Rápido</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ratio Deuda/Ingreso</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @php
                                    $debtRatio = $application->client->income > 0 
                                        ? ($monthlyPayment / $application->client->income) * 100 
                                        : 0;
                                @endphp
                                {{ number_format($debtRatio, 1) }}%
                                @if($debtRatio > 30)
                                    <span class="text-red-600 text-xs">(Alto riesgo)</span>
                                @elseif($debtRatio > 20)
                                    <span class="text-yellow-600 text-xs">(Riesgo moderado)</span>
                                @else
                                    <span class="text-green-600 text-xs">(Bajo riesgo)</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacidad de Pago</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @php
                                    $paymentCapacity = $application->client->income - $application->client->expenses;
                                @endphp
                                ${{ number_format($paymentCapacity, 0, ',', '.') }}
                                @if($paymentCapacity >= $monthlyPayment)
                                    <span class="text-green-600 text-xs">(Suficiente)</span>
                                @else
                                    <span class="text-red-600 text-xs">(Insuficiente)</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documentos</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $application->documents->count() }} archivos
                                @if($application->documents->count() >= 3)
                                    <span class="text-green-600 text-xs">(Completo)</span>
                                @else
                                    <span class="text-yellow-600 text-xs">(Incompleto)</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Approval Modal -->
<div id="approvalModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Aprobar Solicitud</h3>
            <form method="POST" action="{{ route('admin.applications.approve', $application) }}" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')
                
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label for="approved_amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto Aprobado</label>
                        <input type="number" name="approved_amount" id="approved_amount" value="{{ $application->amount }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                               required min="1000" max="1000000">
                    </div>
                    <div>
                        <label for="approved_term" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Plazo (meses)</label>
                        <input type="number" name="approved_term" id="approved_term" value="{{ $application->term_months }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                               required min="6" max="60">
                    </div>
                </div>
                
                <div>
                    <label for="interest_rate" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Tasa de Interés Anual</label>
                    <input type="number" name="interest_rate" id="interest_rate" value="0.15" step="0.01" 
                           class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                           required min="0.05" max="0.50">
                    <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Ejemplo: 0.15 para 15% anual</p>
                </div>
                
                <div>
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Notas (opcional)</label>
                    <textarea name="notes" id="notes" rows="3" 
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500" 
                              placeholder="Comentarios sobre la aprobación..."></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeApprovalModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-green-600 border border-transparent rounded-md hover:bg-green-700">
                        Aprobar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Rejection Modal -->
<div id="rejectionModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden">
    <div class="relative top-20 mx-auto p-5 border w-11/12 md:w-3/4 lg:w-1/2 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Rechazar Solicitud</h3>
            <form method="POST" action="{{ route('admin.applications.reject', $application) }}" class="mt-4 space-y-4">
                @csrf
                @method('PATCH')
                
                <div>
                    <label for="rejection_reason" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Motivo del Rechazo</label>
                    <textarea name="rejection_reason" id="rejection_reason" rows="4" 
                              class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500"
                              placeholder="Explique el motivo del rechazo..." required></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" onclick="closeRejectionModal()" 
                            class="px-4 py-2 text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit" 
                            class="px-4 py-2 text-sm font-medium text-white bg-red-600 border border-transparent rounded-md hover:bg-red-700">
                        Rechazar Solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function openApprovalModal() {
    document.getElementById('approvalModal').classList.remove('hidden');
}

function closeApprovalModal() {
    document.getElementById('approvalModal').classList.add('hidden');
}

function openRejectionModal() {
    document.getElementById('rejectionModal').classList.remove('hidden');
}

function closeRejectionModal() {
    document.getElementById('rejectionModal').classList.add('hidden');
}

// Close modals when clicking outside
document.addEventListener('click', function(e) {
    const approvalModal = document.getElementById('approvalModal');
    const rejectionModal = document.getElementById('rejectionModal');
    
    if (e.target === approvalModal) {
        closeApprovalModal();
    }
    if (e.target === rejectionModal) {
        closeRejectionModal();
    }
});
</script>
@endsection
