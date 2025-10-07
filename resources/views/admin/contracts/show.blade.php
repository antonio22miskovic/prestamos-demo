<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Contrato de Préstamo') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    
                    @if($loan->contract)
                        <!-- Contract Generated -->
                        <div class="mb-6 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg p-4">
                            <div class="flex items-center">
                                <div class="flex-shrink-0">
                                    <svg class="h-5 w-5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                    </svg>
                                </div>
                                <div class="ml-3">
                                    <h3 class="text-sm font-medium text-green-800 dark:text-green-200">
                                        Contrato Generado
                                    </h3>
                                    <div class="mt-2 text-sm text-green-700 dark:text-green-300">
                                        <p>El contrato está disponible para visualización y descarga.</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Contract Actions -->
                        <div class="mb-6 flex space-x-4">
                            <a href="{{ route('admin.contracts.download', $loan->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Descargar PDF
                            </a>
                            <a href="{{ route('admin.applications.show', $loan->loanApplication->id) }}" 
                               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                                </svg>
                                Ver Detalles de Solicitud
                            </a>
                        </div>

                        <!-- Contract Details -->
                        <div class="bg-gray-50 dark:bg-gray-900 rounded-lg p-6">
                            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Detalles del Contrato</h3>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Cliente</h4>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $loan->client->user->name }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $loan->client->user->email }}</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Préstamo</h4>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">${{ number_format($loan->amount, 2) }}</p>
                                    <p class="text-sm text-gray-500 dark:text-gray-400">{{ $loan->term_months }} meses</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</h4>
                                    <p class="mt-1 text-sm text-gray-900 dark:text-white">{{ $loan->interest_rate }}% anual</p>
                                </div>
                                
                                <div>
                                    <h4 class="text-sm font-medium text-gray-500 dark:text-gray-400">Estado</h4>
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                        @if($loan->status === 'approved') bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200
                                        @elseif($loan->status === 'active') bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200
                                        @elseif($loan->status === 'paid') bg-gray-100 text-gray-800 dark:bg-gray-900 dark:text-gray-200
                                        @endif">
                                        {{ ucfirst($loan->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>

                    @else
                        <!-- No Contract -->
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                            </svg>
                            <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay contrato generado</h3>
                            <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">Este préstamo no tiene un contrato asociado.</p>
                            <div class="mt-6">
                                <a href="{{ route('admin.applications.show', $loan->loanApplication->id) }}" 
                                   class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Volver a la Solicitud
                                </a>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
