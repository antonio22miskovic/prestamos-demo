<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Progress Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 text-green-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        Revisión Final
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Listo para enviar
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-green-500 to-green-600 h-2 rounded-full transition-all duration-300" style="width: 100%"></div>
                </div>
                
                <!-- Steps Indicator -->
                <div class="flex justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Información</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Préstamo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Documentos</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-green-600 text-white rounded-full flex items-center justify-center text-sm font-bold">
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        <span class="ml-2 text-sm font-medium text-green-600">Revisión</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <!-- Success Message -->
            @if(session('success'))
                <div class="mb-6 p-4 bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-800 rounded-lg">
                    <div class="flex items-center">
                        <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                        </svg>
                        <span class="text-green-800 dark:text-green-200">{{ session('success') }}</span>
                    </div>
                </div>
            @endif

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar - Summary -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                            Solicitud Completa
                        </h3>
                        
                        <!-- Loan Summary -->
                        <div class="bg-gradient-to-br from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-lg p-4 border border-green-200 dark:border-green-800 mb-6">
                            <div class="text-center mb-4">
                                <div class="text-xs text-green-600 dark:text-green-400 font-medium">MONTO SOLICITADO</div>
                                <div class="text-3xl font-bold text-green-900 dark:text-green-100">${{ number_format($application->amount) }}</div>
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
                        <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800 mb-6">
                            <div class="text-center">
                                <div class="text-xs text-blue-600 dark:text-blue-400 font-medium">CUOTA MENSUAL</div>
                                <div class="text-2xl font-bold text-blue-900 dark:text-blue-100">${{ number_format($monthlyPayment, 2) }}</div>
                            </div>
                        </div>
                        
                        <!-- Documents Status -->
                        <div class="space-y-3">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white">Documentos Cargados:</h4>
                            @php
                                $docNames = [
                                    'identity' => 'Documento de Identidad',
                                    'bank_statement' => 'Estado de Cuenta',
                                    'employment_proof' => 'Comprobante Laboral'
                                ];
                            @endphp
                            
                            @foreach($docNames as $docType => $docName)
                                <div class="flex items-center text-sm">
                                    @if(isset($documents[$docType]))
                                        <svg class="w-4 h-4 text-green-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span class="text-green-700 dark:text-green-300">{{ $docName }}</span>
                                    @else
                                        <svg class="w-4 h-4 text-red-500 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                        </svg>
                                        <span class="text-red-700 dark:text-red-300">{{ $docName }}</span>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

                <!-- Right Content - Final Review -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Revisión Final</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Revisa todos los detalles antes de enviar tu solicitud
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
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">NOMBRE</div>
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
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EMPLEO</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->employment }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EMPRESA</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->company_name }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">EXPERIENCIA</div>
                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->employment_years }} años</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Financial Information -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-green-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                    </svg>
                                    Información Financiera
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">INGRESOS</div>
                                            <div class="text-sm font-medium text-green-600 dark:text-green-400">${{ number_format($client->income, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">GASTOS</div>
                                            <div class="text-sm font-medium text-red-600 dark:text-red-400">${{ number_format($client->expenses, 2) }}</div>
                                        </div>
                                        <div>
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">DISPONIBLE</div>
                                            <div class="text-sm font-medium text-blue-600 dark:text-blue-400">${{ number_format($client->income - $client->expenses, 2) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Loan Details -->
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
                                            <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">MONTO</div>
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

                            <!-- Documents -->
                            <div>
                                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4 flex items-center">
                                    <svg class="w-5 h-5 text-purple-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    Documentos
                                    <a href="{{ route('client.loan-application.step4') }}" class="ml-auto text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                                        Editar
                                    </a>
                                </h3>
                                <div class="bg-gray-50 dark:bg-gray-700 rounded-lg p-4">
                                    <div class="space-y-3">
                                        @foreach($docNames as $docType => $docName)
                                            <div class="flex items-center justify-between p-3 bg-white dark:bg-gray-800 rounded border">
                                                <div class="flex items-center">
                                                    @if(isset($documents[$docType]))
                                                        <svg class="w-5 h-5 text-green-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                                        </svg>
                                                        <div>
                                                            <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $docName }}</div>
                                                            <div class="text-xs text-gray-500 dark:text-gray-400">{{ $documents[$docType]->original_name }}</div>
                                                        </div>
                                                    @else
                                                        <svg class="w-5 h-5 text-red-500 mr-3" fill="currentColor" viewBox="0 0 24 24">
                                                            <path d="M19 6.41L17.59 5 12 10.59 6.41 5 5 6.41 10.59 12 5 17.59 6.41 19 12 13.41 17.59 19 19 17.59 13.41 12z"/>
                                                        </svg>
                                                        <div>
                                                            <div class="text-sm font-medium text-red-700 dark:text-red-300">{{ $docName }}</div>
                                                            <div class="text-xs text-red-500 dark:text-red-400">Falta por cargar</div>
                                                        </div>
                                                    @endif
                                                </div>
                                                @if(isset($documents[$docType]))
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-200">
                                                        Cargado
                                                    </span>
                                                @else
                                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-200">
                                                        Faltante
                                                    </span>
                                                @endif
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Final Confirmation -->
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-6 border border-green-200 dark:border-green-800">
                                <h4 class="text-lg font-semibold text-green-900 dark:text-green-100 mb-4">¡Todo Listo!</h4>
                                <p class="text-sm text-green-800 dark:text-green-200 mb-4">
                                    Tu solicitud está completa y lista para ser enviada. Una vez enviada, nuestro equipo la revisará y te contactaremos con el resultado en un plazo máximo de 24 horas.
                                </p>
                                
                                <form method="POST" action="{{ route('client.loan-application.submit') }}">
                                    @csrf
                                    
                                    <div class="mb-4">
                                        <label for="final_confirm" class="inline-flex items-start">
                                            <input id="final_confirm" type="checkbox" required class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-green-600 shadow-sm focus:ring-green-500 dark:focus:ring-green-600 dark:focus:ring-offset-gray-800 mt-1">
                                            <span class="ms-3 text-sm text-green-800 dark:text-green-200">
                                                Confirmo que toda la información es correcta y autorizo el procesamiento de mi solicitud de préstamo.
                                            </span>
                                        </label>
                                    </div>

                                    <div class="flex items-center justify-between">
                                        <a href="{{ route('client.loan-application.step4') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                            </svg>
                                            Volver a Documentos
                                        </a>
                                        
                                        <button type="submit" class="inline-flex items-center px-8 py-3 bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 text-white text-lg font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors">
                                            <svg class="w-6 h-6 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                            </svg>
                                            Enviar Solicitud
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
