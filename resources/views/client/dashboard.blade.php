<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Mi Panel de Cliente') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Bienvenida -->
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        ¡Bienvenido, {{ auth()->user()->name }}!
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400">
                        Aquí puedes gestionar tus solicitudes de préstamo y ver el estado de tus créditos.
                    </p>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Columna principal -->
                <div class="lg:col-span-2 space-y-6">
                    <!-- Solicitud activa -->
                    @if($activeApplication)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border-l-4 border-blue-500">
                            <div class="p-6">
                                <div class="flex items-center justify-between mb-4">
                                    <div class="flex items-center">
                                        <div class="flex-shrink-0">
                                            <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900 rounded-full flex items-center justify-center">
                                                <svg class="w-6 h-6 text-blue-600 dark:text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="ml-4">
                                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                                Solicitud en Proceso
                                            </h3>
                                            <p class="text-sm text-gray-500 dark:text-gray-400">
                                                Solicitud ID: #{{ $activeApplication->id }}
                                            </p>
                                        </div>
                                    </div>
                                    @php
                                        $statusColors = [
                                            'draft' => 'bg-gray-100 text-gray-800 border-gray-200',
                                            'pending' => 'bg-yellow-100 text-yellow-800 border-yellow-200',
                                            'approved' => 'bg-green-100 text-green-800 border-green-200',
                                            'rejected' => 'bg-red-100 text-red-800 border-red-200'
                                        ];
                                        $statusLabels = [
                                            'draft' => 'En borrador',
                                            'pending' => 'En revisión',
                                            'approved' => 'Aprobado',
                                            'rejected' => 'Rechazado'
                                        ];
                                    @endphp
                                    <span class="px-3 py-1 text-sm font-semibold rounded-full border {{ $statusColors[$activeApplication->status] ?? 'bg-gray-100 text-gray-800 border-gray-200' }}">
                                        {{ $statusLabels[$activeApplication->status] ?? ucfirst($activeApplication->status) }}
                                    </span>
                                </div>

                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4">
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Monto solicitado</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            ${{ number_format($activeApplication->amount, 2) }}
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Plazo</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $activeApplication->term_months }} meses
                                        </p>
                                    </div>
                                    <div>
                                        <p class="text-sm text-gray-500 dark:text-gray-400">Propósito</p>
                                        <p class="text-lg font-semibold text-gray-900 dark:text-gray-100">
                                            {{ $activeApplication->purpose }}
                                        </p>
                                    </div>
                                </div>

                                <!-- Barra de progreso -->
                                <div class="mb-4">
                                    <div class="flex justify-between text-sm text-gray-600 dark:text-gray-400 mb-2">
                                        <span>Progreso de la solicitud</span>
                                        <span>{{ $activeApplication->current_step }}/4 pasos</span>
                                    </div>
                                    <div class="w-full bg-gray-200 rounded-full h-2.5 dark:bg-gray-700">
                                        <div class="bg-blue-600 h-2.5 rounded-full" style="width: {{ ($activeApplication->current_step / 4) * 100 }}%"></div>
                                    </div>
                                </div>

                                @if($activeApplication->status === 'draft')
                                    <div class="flex space-x-3">
                                        <a href="#" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                            Continuar solicitud
                                        </a>
                                    </div>
                                @elseif($activeApplication->status === 'pending')
                                    <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-md p-4">
                                        <p class="text-sm text-yellow-800 dark:text-yellow-200">
                                            Tu solicitud está siendo revisada por nuestro equipo. Te notificaremos cuando tengamos una respuesta.
                                        </p>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @else
                        <!-- Nueva solicitud -->
                        <div class="bg-gradient-to-br from-blue-50 to-indigo-100 dark:from-blue-900/20 dark:to-indigo-900/20 overflow-hidden shadow-sm sm:rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="p-8 text-center">
                                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-6 shadow-lg">
                                    <svg class="w-10 h-10 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-gray-900 dark:text-gray-100 mb-3">
                                    ¿Necesitas un préstamo?
                                </h3>
                                <p class="text-gray-600 dark:text-gray-400 mb-6 max-w-md mx-auto">
                                    Inicia tu solicitud de crédito en solo unos minutos. Proceso 100% digital con evaluación automática y respuesta inmediata.
                                </p>
                                
                                <!-- Features mini -->
                                <div class="flex justify-center space-x-8 mb-6 text-sm">
                                    <div class="flex items-center text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Rápido
                                    </div>
                                    <div class="flex items-center text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Seguro
                                    </div>
                                    <div class="flex items-center text-green-600 dark:text-green-400">
                                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                                        </svg>
                                        Fácil
                                    </div>
                                </div>
                                
                                <a href="#" class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-semibold rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:scale-105">
                                    <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                                    </svg>
                                    Solicitar préstamo
                                </a>
                            </div>
                        </div>
                    @endif

                    <!-- Préstamos activos -->
                    @if($activeLoans->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    Mis Préstamos Activos
                                </h3>
                                
                                <div class="space-y-4">
                                    @foreach($activeLoans as $loan)
                                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                            <div class="flex justify-between items-start mb-3">
                                                <div>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        Préstamo #{{ $loan->id }}
                                                    </p>
                                                    <p class="text-sm text-gray-500 dark:text-gray-400">
                                                        Aprobado el {{ $loan->approved_at?->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                                <span class="px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                                    Activo
                                                </span>
                                            </div>
                                            
                                            <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm">
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400">Monto</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        ${{ number_format($loan->amount, 2) }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400">Cuota mensual</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        ${{ number_format($loan->monthly_fee, 2) }}
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400">Tasa</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $loan->interest_rate }}% anual
                                                    </p>
                                                </div>
                                                <div>
                                                    <p class="text-gray-500 dark:text-gray-400">Vencimiento</p>
                                                    <p class="font-semibold text-gray-900 dark:text-gray-100">
                                                        {{ $loan->end_date->format('d/m/Y') }}
                                                    </p>
                                                </div>
                                            </div>
                                            
                                            <div class="mt-3 flex space-x-3">
                                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Ver cronograma
                                                </a>
                                                <a href="#" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                                    Realizar pago
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Sidebar -->
                <div class="space-y-6">
                    <!-- Información del perfil -->
                    <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                        <div class="p-6">
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                Mi Perfil
                            </h3>
                            
                            <div class="space-y-3 text-sm">
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Nombre</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->name }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Email</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->email }}</p>
                                </div>
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Teléfono</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ auth()->user()->phone ?? 'No registrado' }}</p>
                                </div>
                                @if($client->employment)
                                <div>
                                    <p class="text-gray-500 dark:text-gray-400">Empleo</p>
                                    <p class="font-medium text-gray-900 dark:text-gray-100">{{ $client->employment }}</p>
                                </div>
                                @endif
                            </div>
                            
                            <div class="mt-4">
                                <a href="{{ route('profile.edit') }}" class="text-blue-600 hover:text-blue-800 text-sm font-medium">
                                    Editar perfil
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Historial reciente -->
                    @if($loanHistory->count() > 0)
                        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                            <div class="p-6">
                                <h3 class="text-lg font-semibold text-gray-900 dark:text-gray-100 mb-4">
                                    Historial Reciente
                                </h3>
                                
                                <div class="space-y-3">
                                    @foreach($loanHistory as $application)
                                        <div class="flex justify-between items-center text-sm">
                                            <div>
                                                <p class="font-medium text-gray-900 dark:text-gray-100">
                                                    ${{ number_format($application->amount, 0) }}
                                                </p>
                                                <p class="text-gray-500 dark:text-gray-400">
                                                    {{ $application->created_at->format('d/m/Y') }}
                                                </p>
                                            </div>
                                            <span class="px-2 py-1 text-xs font-semibold rounded-full {{ $statusColors[$application->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
