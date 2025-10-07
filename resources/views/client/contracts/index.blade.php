@extends('layouts.client')

@section('title', 'Mis Contratos')

@section('content')
    <div class="space-y-6">
        @if($loans->count() > 0)
            <!-- Contracts List -->
            @foreach($loans as $loan)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                Contrato #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                @if($loan->contract) bg-green-100 text-green-800
                                @else bg-yellow-100 text-yellow-800
                                @endif">
                                @if($loan->contract) Generado
                                @else Pendiente
                                @endif
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto del Préstamo</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($loan->amount, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ number_format($loan->interest_rate * 100, 1) }}% anual
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $loan->term_months }} meses
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Aprobación</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    {{ $loan->approved_at ? $loan->approved_at->format('d/m/Y') : 'N/A' }}
                                </dd>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            @if($loan->contract)
                                <a href="{{ route('client.contracts.show', $loan->id) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Ver Contrato
                                </a>
                                
                                <a href="{{ route('client.contracts.download', $loan->id) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Descargar PDF
                                </a>
                            @else
                                <a href="#" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors"
                                   onclick="confirmContractGeneration('{{ route('client.contracts.generate', $loan->id) }}'); return false;">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                                    </svg>
                                    Generar Contrato
                                </a>
                            @endif

                            <a href="{{ route('client.loans.show', $loan->id) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Ver Estado del Préstamo
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- No Contracts -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No tienes contratos disponibles</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Los contratos aparecerán aquí una vez que tus préstamos sean aprobados y firmados.
                    </p>
                    <div class="mt-6">
                        <a href="{{ route('client.applications.index') }}" 
                           class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            Ver Mis Solicitudes
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Information Card -->
        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-blue-800 dark:text-blue-200">
                        Información sobre Contratos
                    </h3>
                    <div class="mt-2 text-sm text-blue-700 dark:text-blue-300">
                        <ul class="list-disc list-inside space-y-1">
                            <li>Los contratos se generan automáticamente cuando tu préstamo es aprobado</li>
                            <li>Puedes descargar una copia en PDF en cualquier momento</li>
                            <li>Todos los contratos incluyen términos y condiciones detallados</li>
                            <li>Conserva una copia para tus registros personales</li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
