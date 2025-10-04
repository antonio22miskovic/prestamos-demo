@extends('layouts.client')

@section('title', 'Mis Créditos')

@section('content')
    <div class="space-y-6">
        @if($activeLoans->count() > 0)
            <!-- Active Loans -->
            @foreach($activeLoans as $loan)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                        <div class="flex items-center justify-between">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                                Préstamo #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}
                            </h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $loan->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                                {{ $loan->status === 'active' ? 'Activo' : 'Aprobado' }}
                            </span>
                        </div>
                    </div>
                    
                    <div class="px-6 py-4">
                        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Original</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($loan->amount, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Pendiente</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($loan->remaining_balance, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    ${{ number_format($loan->monthly_fee, 0, ',', '.') }}
                                </dd>
                            </div>
                            <div>
                                <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Próximo Pago</dt>
                                <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                    @php
                                        $nextInstallment = $loan->installments->where('status', 'pending')->first();
                                    @endphp
                                    @if($nextInstallment)
                                        {{ $nextInstallment->due_date->format('d/m/Y') }}
                                    @else
                                        <span class="text-green-600">Completado</span>
                                    @endif
                                </dd>
                            </div>
                        </div>

                        <!-- Progress Bar -->
                        @php
                            $totalPaid = $loan->amount - $loan->remaining_balance;
                            $progressPercentage = $loan->amount > 0 ? ($totalPaid / $loan->amount) * 100 : 0;
                        @endphp
                        <div class="mt-6">
                            <div class="flex items-center justify-between text-sm">
                                <span class="font-medium text-gray-700 dark:text-gray-300">Progreso del Préstamo</span>
                                <span class="text-gray-500 dark:text-gray-400">{{ number_format($progressPercentage, 1) }}%</span>
                            </div>
                            <div class="mt-2 w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-2 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                            </div>
                            <div class="mt-2 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                <span>Pagado: ${{ number_format($totalPaid, 0, ',', '.') }}</span>
                                <span>Pendiente: ${{ number_format($loan->remaining_balance, 0, ',', '.') }}</span>
                            </div>
                        </div>

                        <div class="mt-6 flex flex-col sm:flex-row gap-3">
                            <a href="{{ route('client.loans.show', $loan->id) }}" 
                               class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                                </svg>
                                Ver Detalles
                            </a>
                            
                            @if($loan->contract_signed_at)
                                <a href="{{ route('client.contracts.show', $loan->id) }}" 
                                   class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                    Ver Contrato
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <!-- No Active Loans -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-6 py-12 text-center">
                    <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                    </svg>
                    <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No tienes créditos activos</h3>
                    <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                        Una vez que tu solicitud sea aprobada, tus créditos aparecerán aquí.
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

        <!-- Quick Stats -->
        @if($activeLoans->count() > 0)
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-blue-100 dark:bg-blue-900 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-blue-600 dark:text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Total Adeudado</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                @php
                                    $totalOutstanding = 0;
                                    foreach($activeLoans as $loan) {
                                        $totalOutstanding += $loan->remaining_balance;
                                    }
                                @endphp
                                ${{ number_format($totalOutstanding, 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 dark:bg-green-900 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600 dark:text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual Total</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                ${{ number_format($activeLoans->sum('monthly_fee'), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-purple-100 dark:bg-purple-900 rounded-md flex items-center justify-center">
                                <svg class="w-5 h-5 text-purple-600 dark:text-purple-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Créditos Activos</p>
                            <p class="text-lg font-semibold text-gray-900 dark:text-white">
                                {{ $activeLoans->count() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
