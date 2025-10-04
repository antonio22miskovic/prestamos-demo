<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Progress Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                        </svg>
                        Solicitud de Préstamo
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Paso 2 de 3
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 h-2 rounded-full transition-all duration-300" style="width: 66.66%"></div>
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
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Detalles del Préstamo</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Revisión y Envío</span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main Content -->
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                <!-- Left Sidebar - Loan Calculator -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z"/>
                            </svg>
                            Calculadora de Préstamo
                        </h3>
                        
                        <!-- Loan Summary -->
                        <div class="space-y-4">
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <div class="text-center">
                                    <div class="text-xs text-blue-600 dark:text-blue-400 font-medium">MONTO SOLICITADO</div>
                                    <div id="loan-amount-display" class="text-2xl font-bold text-blue-900 dark:text-blue-100">$0</div>
                                </div>
                            </div>
                            
                            <div class="grid grid-cols-2 gap-3">
                                <div class="text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">PLAZO</div>
                                    <div id="term-display" class="text-lg font-semibold text-gray-900 dark:text-white">0 meses</div>
                                </div>
                                <div class="text-center">
                                    <div class="text-xs text-gray-500 dark:text-gray-400 font-medium">TASA ANUAL</div>
                                    <div class="text-lg font-semibold text-gray-900 dark:text-white">15%</div>
                                </div>
                            </div>
                            
                            <div class="bg-green-50 dark:bg-green-900/20 rounded-lg p-4 border border-green-200 dark:border-green-800">
                                <div class="text-center">
                                    <div class="text-xs text-green-600 dark:text-green-400 font-medium">CUOTA MENSUAL</div>
                                    <div id="monthly-payment-display" class="text-xl font-bold text-green-900 dark:text-green-100">$0</div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Capacity Analysis -->
                        <div class="mt-6 p-4 bg-gray-50 dark:bg-gray-700 rounded-lg">
                            <h4 class="text-sm font-semibold text-gray-900 dark:text-white mb-3">Análisis de Capacidad</h4>
                            <div class="space-y-2">
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600 dark:text-gray-400">Ingresos disponibles:</span>
                                    <span class="font-medium text-gray-900 dark:text-white">${{ number_format($client->income - $client->expenses, 2) }}</span>
                                </div>
                                <div class="flex justify-between text-xs">
                                    <span class="text-gray-600 dark:text-gray-400">Cuota propuesta:</span>
                                    <span id="capacity-payment" class="font-medium text-gray-900 dark:text-white">$0</span>
                                </div>
                                <div class="flex justify-between text-xs border-t pt-2">
                                    <span class="text-gray-600 dark:text-gray-400">Disponible después:</span>
                                    <span id="remaining-capacity" class="font-medium text-gray-900 dark:text-white">$0</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Detalles del Préstamo</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Especifica el monto, plazo y propósito de tu préstamo
                            </p>
                        </div>

                        <form method="POST" action="{{ route('client.loan-application.process-step2') }}" class="p-6 space-y-6">
                            @csrf

                            <!-- Loan Amount -->
                            <div>
                                <label for="amount" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                    </svg>
                                    Monto del Préstamo
                                </label>
                                <div class="relative">
                                    <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-lg">$</span>
                                    <input type="number" id="amount" name="amount" value="{{ old('amount', $application->amount) }}" required min="1000" max="100000" step="100"
                                           class="mt-1 block w-full pl-8 pr-3 py-3 text-lg border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                           placeholder="0">
                                </div>
                                <div class="mt-2 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Mínimo: $1,000</span>
                                    <span>Máximo: $100,000</span>
                                </div>
                                @error('amount')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Amount Suggestions -->
                            <div class="grid grid-cols-2 md:grid-cols-4 gap-3">
                                @foreach([5000, 10000, 25000, 50000] as $suggestedAmount)
                                <button type="button" onclick="setAmount({{ $suggestedAmount }})" 
                                        class="p-3 text-center border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">${{ number_format($suggestedAmount) }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">{{ $suggestedAmount <= 10000 ? 'Básico' : ($suggestedAmount <= 25000 ? 'Intermedio' : 'Avanzado') }}</div>
                                </button>
                                @endforeach
                            </div>

                            <!-- Term -->
                            <div>
                                <label for="term_months" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    Plazo de Pago
                                </label>
                                <select id="term_months" name="term_months" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Selecciona el plazo</option>
                                    <option value="6" {{ old('term_months', $application->term_months) == 6 ? 'selected' : '' }}>6 meses</option>
                                    <option value="12" {{ old('term_months', $application->term_months) == 12 ? 'selected' : '' }}>12 meses</option>
                                    <option value="18" {{ old('term_months', $application->term_months) == 18 ? 'selected' : '' }}>18 meses</option>
                                    <option value="24" {{ old('term_months', $application->term_months) == 24 ? 'selected' : '' }}>24 meses</option>
                                    <option value="36" {{ old('term_months', $application->term_months) == 36 ? 'selected' : '' }}>36 meses</option>
                                    <option value="48" {{ old('term_months', $application->term_months) == 48 ? 'selected' : '' }}>48 meses</option>
                                </select>
                                @error('term_months')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Purpose -->
                            <div>
                                <label for="purpose" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M14,2H6A2,2 0 0,0 4,4V20A2,2 0 0,0 6,22H18A2,2 0 0,0 20,20V8L14,2M18,20H6V4H13V9H18V20Z"/>
                                    </svg>
                                    Propósito del Préstamo
                                </label>
                                <textarea id="purpose" name="purpose" rows="4" required maxlength="500"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                          placeholder="Describe brevemente para qué necesitas el préstamo...">{{ old('purpose', $application->purpose) }}</textarea>
                                <div class="mt-1 flex justify-between text-xs text-gray-500 dark:text-gray-400">
                                    <span>Sé específico sobre el uso de los fondos</span>
                                    <span id="purpose-counter">0/500</span>
                                </div>
                                @error('purpose')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Purpose Suggestions -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-3">
                                @foreach(['Consolidación de deudas', 'Mejoras del hogar', 'Emergencia médica', 'Educación', 'Vehículo', 'Emprendimiento'] as $purposeSuggestion)
                                <button type="button" onclick="setPurpose('{{ $purposeSuggestion }}')" 
                                        class="p-3 text-left border border-gray-300 dark:border-gray-600 rounded-lg hover:bg-blue-50 dark:hover:bg-blue-900/20 hover:border-blue-300 dark:hover:border-blue-600 transition-colors">
                                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $purposeSuggestion }}</div>
                                    <div class="text-xs text-gray-500 dark:text-gray-400">Click para seleccionar</div>
                                </button>
                                @endforeach
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('client.loan-application.step1') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Paso Anterior
                                </a>
                                
                                <button type="submit" class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                    Continuar al Paso 3
                                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Loan Calculator -->
    <script>
        const availableIncome = {{ $client->income - $client->expenses }};
        
        function calculateLoan() {
            const amount = parseFloat(document.getElementById('amount').value) || 0;
            const termMonths = parseInt(document.getElementById('term_months').value) || 12;
            
            // Calculate monthly payment (15% annual rate)
            const annualRate = 0.15;
            const monthlyRate = annualRate / 12;
            let monthlyPayment = 0;
            
            if (amount > 0 && termMonths > 0) {
                monthlyPayment = (amount * monthlyRate * Math.pow(1 + monthlyRate, termMonths)) / 
                               (Math.pow(1 + monthlyRate, termMonths) - 1);
            }
            
            // Update displays
            document.getElementById('loan-amount-display').textContent = '$' + amount.toLocaleString();
            document.getElementById('term-display').textContent = termMonths + ' meses';
            document.getElementById('monthly-payment-display').textContent = '$' + monthlyPayment.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            // Update capacity analysis
            document.getElementById('capacity-payment').textContent = '$' + monthlyPayment.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            const remaining = availableIncome - monthlyPayment;
            document.getElementById('remaining-capacity').textContent = '$' + remaining.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            // Change color based on capacity
            const remainingElement = document.getElementById('remaining-capacity');
            if (remaining >= 0) {
                remainingElement.className = 'font-medium text-green-600 dark:text-green-400';
            } else {
                remainingElement.className = 'font-medium text-red-600 dark:text-red-400';
            }
        }
        
        function setAmount(amount) {
            document.getElementById('amount').value = amount;
            calculateLoan();
        }
        
        function setPurpose(purpose) {
            document.getElementById('purpose').value = purpose;
            updatePurposeCounter();
        }
        
        function updatePurposeCounter() {
            const purpose = document.getElementById('purpose').value;
            const counter = document.getElementById('purpose-counter');
            counter.textContent = purpose.length + '/500';
            
            if (purpose.length > 450) {
                counter.className = 'text-red-600 dark:text-red-400';
            } else {
                counter.className = 'text-gray-500 dark:text-gray-400';
            }
        }
        
        // Add event listeners
        document.getElementById('amount').addEventListener('input', calculateLoan);
        document.getElementById('term_months').addEventListener('change', calculateLoan);
        document.getElementById('purpose').addEventListener('input', updatePurposeCounter);
        
        // Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            calculateLoan();
            updatePurposeCounter();
        });
    </script>
</x-app-layout>
