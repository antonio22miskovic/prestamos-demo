<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Progress Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Solicitud de Préstamo
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Paso 3 de 3
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                </div>
                
                <!-- Steps Indicator -->
                <div class="flex justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Información Personal</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Detalles del Préstamo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Revisión y Envío</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar - Loan Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            Resumen del Préstamo
                        </h3>
                        
                        <!-- Loan Details Card -->
                        <div class="bg-gradient-to-br from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800 mb-6">
                            <div class="text-center mb-4">
                                <div class="text-xs text-blue-600 dark:text-blue-400 font-medium">MONTO APROBADO</div>
                                <div class="text-3xl font-bold text-blue-900 dark:text-blue-100">${{ number_format($application->amount) }}</div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-4 text-center">
                                <div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">PLAZO</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">{{ $application->term_months }} meses</div>
                                </div>
                                <div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400 font-medium">TASA</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">15% anual</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Monthly Payment -->
                        <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800 mb-6">
                            <div class="text-center">
                                <div class="text-xs text-green-600 dark:text-green-400 font-medium">CUOTA MENSUAL</div>
                                <div class="text-2xl font-bold text-green-900 dark:text-green-100">${{ number_format($monthlyPayment, 2) }}</div>
                                <div class="text-xs text-green-700 dark:text-green-300 mt-1">
                                    Total a pagar: ${{ number_format($monthlyPayment * $application->term_months, 2) }}
                                </div>
                            </div>
                        </div>
                        
                        <!-- Next Steps -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Próximos pasos:</h4>
                            <div class="space-y-2 text-xs text-gray-600 dark:text-gray-400">
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mr-2 text-xs font-bold">1</div>
                                    <span>Evaluación automática (2-5 min)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mr-2 text-xs font-bold">2</div>
                                    <span>Revisión por especialista (1-2 horas)</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mr-2 text-xs font-bold">3</div>
                                    <span>Notificación de resultado</span>
                                </div>
                                <div class="flex items-center">
                                    <div class="w-4 h-4 bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 rounded-full flex items-center justify-center mr-2 text-xs font-bold">4</div>
                                    <span>Desembolso (si es aprobado)</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Review -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Revisión de Solicitud</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Revisa toda la información antes de enviar tu solicitud
                            </p>
                        </div>

                        <div class="p-6 space-y-8">
                            <!-- Personal Information Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                    Información Personal
                                    <a href="{{ route('client.loan-application.step1') }}" class="ml-auto text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Editar
                                    </a>
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">NOMBRE COMPLETO</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->user->name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EMAIL</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->user->email }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">TELÉFONO</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->user->phone }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">SITUACIÓN LABORAL</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->employment }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EMPRESA</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->company_name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EXPERIENCIA</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->employment_years }} {{ $client->employment_years == 1 ? 'año' : 'años' }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Information Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                    </svg>
                                    Información Financiera
                                    <a href="{{ route('client.loan-application.step1') }}" class="ml-auto text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Editar
                                    </a>
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">INGRESOS MENSUALES</div>
                                            <div class="text-sm font-medium text-green-600 dark:text-green-400">${{ number_format($client->income, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">GASTOS MENSUALES</div>
                                            <div class="text-sm font-medium text-red-600 dark:text-red-400">${{ number_format($client->expenses, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">DISPONIBLE</div>
                                            <div class="text-sm font-medium text-blue-600 dark:text-blue-400">${{ number_format($client->income - $client->expenses, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loan Details Section -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                    </svg>
                                    Detalles del Préstamo
                                    <a href="{{ route('client.loan-application.step2') }}" class="ml-auto text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Editar
                                    </a>
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">MONTO SOLICITADO</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($application->amount) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">PLAZO</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $application->term_months }} meses</div>
                                        </div>
                                    </div>
                                    <div>
                                        <div class="text-xs text-gray-500 dark:text-gray-400 font-medium mb-2">PROPÓSITO</div>
                                        <div class="text-sm text-gray-900 dark:text-white bg-white dark:bg-gray-800 p-3 rounded border">
                                            {{ $application->purpose }}
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Capacity Analysis -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-orange-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                                    </svg>
                                    Análisis de Capacidad de Pago
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    @php
                                        $availableIncome = $client->income - $client->expenses;
                                        $remainingAfterPayment = $availableIncome - $monthlyPayment;
                                        $capacityPercentage = $availableIncome > 0 ? ($monthlyPayment / $availableIncome) * 100 : 100;
                                    @endphp
                                    
                                    <div class="space-y-3">
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Ingresos disponibles:</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($availableIncome, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center">
                                            <span class="text-sm text-gray-600 dark:text-gray-400">Cuota mensual propuesta:</span>
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($monthlyPayment, 2) }}</span>
                                        </div>
                                        <div class="flex justify-between items-center pt-2 border-t border-gray-200 dark:border-gray-600">
                                            <span class="text-sm font-medium text-gray-900 dark:text-white">Disponible después del pago:</span>
                                            <span class="text-sm font-bold {{ $remainingAfterPayment >= 0 ? 'text-green-600 dark:text-green-400' : 'text-red-600 dark:text-red-400' }}">
                                                ${{ number_format($remainingAfterPayment, 2) }}
                                            </span>
                                        </div>
                                        
                                        <!-- Capacity Bar -->
                                        <div class="mt-4">
                                            <div class="flex justify-between text-xs text-gray-500 dark:text-gray-400 mb-1">
                                                <span>Uso de capacidad de pago</span>
                                                <span>{{ number_format($capacityPercentage, 1) }}%</span>
                                            </div>
                                            <div class="w-full bg-gray-200 dark:bg-gray-600 rounded-full h-2">
                                                <div class="h-2 rounded-full transition-all duration-300 {{ $capacityPercentage <= 70 ? 'bg-green-500' : ($capacityPercentage <= 85 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                                     style="width: {{ min($capacityPercentage, 100) }}%"></div>
                                            </div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 mt-1">
                                                @if($capacityPercentage <= 70)
                                                    ✅ Capacidad de pago excelente
                                                @elseif($capacityPercentage <= 85)
                                                    ⚠️ Capacidad de pago moderada
                                                @else
                                                    ❌ Capacidad de pago limitada
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Terms and Conditions -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-6 border border-blue-200 dark:border-blue-800">
                                <h4 class="text-sm font-semibold text-blue-900 dark:text-blue-100 mb-3">Términos y Condiciones</h4>
                                <div class="space-y-2 text-xs text-blue-800 dark:text-blue-200">
                                    <div class="flex items-start">
                                        <svg class="w-3 h-3 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span>La tasa de interés es fija durante todo el plazo del préstamo.</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-3 h-3 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span>No hay penalidades por pago anticipado.</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-3 h-3 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span>Los pagos se debitan automáticamente de tu cuenta bancaria.</span>
                                    </div>
                                    <div class="flex items-start">
                                        <svg class="w-3 h-3 text-blue-600 mt-0.5 mr-2 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span>Esta solicitud no afecta tu score crediticio hasta la aprobación.</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Submit Form -->
                            <form method="POST" action="{{ route('client.loan-application.submit') }}" class="pt-6 border-t border-gray-200 dark:border-gray-700">
                                @csrf
                                
                                <!-- Confirmation Checkbox -->
                                <div class="mb-6">
                                    <label for="confirm" class="inline-flex items-start">
                                        <input id="confirm" type="checkbox" required class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 mt-1">
                                        <span class="ms-3 text-sm text-gray-600 dark:text-gray-400">
                                            Confirmo que toda la información proporcionada es veraz y completa. Entiendo que cualquier información falsa puede resultar en el rechazo de mi solicitud.
                                        </span>
                                    </label>
                                </div>

                                <!-- Form Actions -->
                                <div class="flex items-center justify-between">
                                <a href="{{ route('client.loan-application.step2') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Paso Anterior
                                </a>
                                
                                <a href="{{ route('client.loan-application.step4') }}" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Continuar a Documentos
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
