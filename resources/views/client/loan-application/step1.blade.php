<x-app-layout>
    <div class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-blue-50 dark:from-gray-900 dark:via-gray-800 dark:to-gray-900">
        <!-- Progress Header -->
        <div class="bg-white dark:bg-gray-800 shadow-sm border-b border-gray-200 dark:border-gray-700">
            <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-6">
                <div class="flex items-center justify-between mb-4">
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-white flex items-center">
                        <svg class="w-8 h-8 text-blue-600 mr-3" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                        Solicitud de Préstamo
                    </h1>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Paso 1 de 3
                    </div>
                </div>
                
                <!-- Progress Bar -->
                <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                    <div class="bg-gradient-to-r from-blue-600 to-blue-700 h-2 rounded-full transition-all duration-300" style="width: 33.33%"></div>
                </div>
                
                <!-- Steps Indicator -->
                <div class="flex justify-between mt-4">
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-blue-600 text-white rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <span class="ml-2 text-sm font-medium text-blue-600">Información Personal</span>
                    </div>
                    <div class="flex items-center">
                        <div class="w-8 h-8 bg-gray-300 dark:bg-gray-600 text-gray-600 dark:text-gray-400 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <span class="ml-2 text-sm text-gray-500 dark:text-gray-400">Detalles del Préstamo</span>
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
                <!-- Left Sidebar - Information -->
                <div class="lg:col-span-1">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm p-6 sticky top-8">
                        <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4 flex items-center">
                            <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                            ¿Por qué necesitamos esta información?
                        </h3>
                        <div class="space-y-4 text-sm text-gray-600 dark:text-gray-400">
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Evaluación de Capacidad</p>
                                    <p>Analizamos tus ingresos y gastos para determinar el monto adecuado.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Mejores Condiciones</p>
                                    <p>Tu historial laboral nos ayuda a ofrecerte mejores tasas de interés.</p>
                                </div>
                            </div>
                            <div class="flex items-start space-x-3">
                                <svg class="w-5 h-5 text-green-500 mt-0.5 flex-shrink-0" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                </svg>
                                <div>
                                    <p class="font-medium text-gray-900 dark:text-white">Proceso Rápido</p>
                                    <p>Con información completa, podemos evaluar tu solicitud en minutos.</p>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Security Badge -->
                        <div class="mt-6 p-3 bg-blue-50 dark:bg-blue-900/20 rounded-lg border border-blue-200 dark:border-blue-800">
                            <div class="flex items-center text-blue-800 dark:text-blue-200">
                                <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                                </svg>
                                <span class="text-xs font-medium">Datos protegidos con encriptación SSL</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Content - Form -->
                <div class="lg:col-span-2">
                    <div class="bg-white dark:bg-gray-800 rounded-lg shadow-sm">
                        <div class="p-6 border-b border-gray-200 dark:border-gray-700">
                            <h2 class="text-xl font-semibold text-gray-900 dark:text-white">Información Personal y Laboral</h2>
                            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                                Cuéntanos sobre tu situación laboral y financiera actual
                            </p>
                        </div>

                        <form method="POST" action="{{ route('client.loan-application.process-step1') }}" class="p-6 space-y-6">
                            @csrf

                            <!-- Employment Status -->
                            <div>
                                <label for="employment" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                    Situación Laboral
                                </label>
                                <select id="employment" name="employment" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Selecciona tu situación laboral</option>
                                    <option value="Empleado privado" {{ old('employment', $client->employment) == 'Empleado privado' ? 'selected' : '' }}>Empleado privado</option>
                                    <option value="Empleado público" {{ old('employment', $client->employment) == 'Empleado público' ? 'selected' : '' }}>Empleado público</option>
                                    <option value="Independiente" {{ old('employment', $client->employment) == 'Independiente' ? 'selected' : '' }}>Trabajador independiente</option>
                                    <option value="Empresario" {{ old('employment', $client->employment) == 'Empresario' ? 'selected' : '' }}>Empresario</option>
                                    <option value="Pensionado" {{ old('employment', $client->employment) == 'Pensionado' ? 'selected' : '' }}>Pensionado</option>
                                </select>
                                @error('employment')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Company Name -->
                            <div>
                                <label for="company_name" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 7V3H2v18h20V7H12zM6 19H4v-2h2v2zm0-4H4v-2h2v2zm0-4H4V9h2v2zm0-4H4V5h2v2zm4 12H8v-2h2v2zm0-4H8v-2h2v2zm0-4H8V9h2v2zm0-4H8V5h2v2zm10 12h-8v-2h2v-2h-2v-2h2v-2h-2V9h8v10zm-2-8h-2v2h2v-2zm0 4h-2v2h2v-2z"/>
                                    </svg>
                                    Empresa o Institución
                                </label>
                                <input type="text" id="company_name" name="company_name" value="{{ old('company_name', $client->company_name) }}" required 
                                       class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                       placeholder="Nombre de tu empresa o institución">
                                @error('company_name')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Employment Years -->
                            <div>
                                <label for="employment_years" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                    <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                    Años de Experiencia Laboral
                                </label>
                                <select id="employment_years" name="employment_years" required class="mt-1 block w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                                    <option value="">Selecciona tus años de experiencia</option>
                                    @for($i = 0; $i <= 30; $i++)
                                        <option value="{{ $i }}" {{ old('employment_years', $client->employment_years) == $i ? 'selected' : '' }}>
                                            {{ $i }} {{ $i == 1 ? 'año' : 'años' }}
                                        </option>
                                    @endfor
                                </select>
                                @error('employment_years')
                                    <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                @enderror
                            </div>

                            <!-- Income and Expenses Row -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Monthly Income -->
                                <div>
                                    <label for="income" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-1 text-green-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm1.41 16.09V20h-2.67v-1.93c-1.71-.36-3.16-1.46-3.27-3.4h1.96c.1 1.05.82 1.87 2.65 1.87 1.96 0 2.4-.98 2.4-1.59 0-.83-.44-1.61-2.67-2.14-2.48-.6-4.18-1.62-4.18-3.67 0-1.72 1.39-2.84 3.11-3.21V4h2.67v1.95c1.86.45 2.79 1.86 2.85 3.39H14.3c-.05-1.11-.64-1.87-2.22-1.87-1.5 0-2.4.68-2.4 1.64 0 .84.65 1.39 2.67 1.91s4.18 1.39 4.18 3.91c-.01 1.83-1.38 2.83-3.12 3.16z"/>
                                        </svg>
                                        Ingresos Mensuales
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                        <input type="text" id="income" value="{{ old('income', $client->income) }}"
                                               class="mt-1 block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="0.00">
                                        <input type="hidden" id="income_hidden" name="income">
                                    </div>
                                    @error('income')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>

                                <!-- Monthly Expenses -->
                                <div>
                                    <label for="expenses" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                        <svg class="w-4 h-4 inline mr-1 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M7,15H9C9,16.08 10.37,17 12,17C13.63,17 15,16.08 15,15C15,13.9 13.96,13.5 11.76,12.97C9.64,12.44 7,11.78 7,9C7,7.21 8.47,5.69 10.5,5.18V3H13.5V5.18C15.53,5.69 17,7.21 17,9H15C15,7.92 13.63,7 12,7C10.37,7 9,7.92 9,9C9,10.1 10.04,10.5 12.24,11.03C14.36,11.56 17,12.22 17,15C17,16.79 15.53,18.31 13.5,18.82V21H10.5V18.82C8.47,18.31 7,16.79 7,15Z"/>
                                        </svg>
                                        Gastos Mensuales
                                    </label>
                                    <div class="relative">
                                        <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                        <input type="text" id="expenses" value="{{ old('expenses', $client->expenses) }}"
                                               class="mt-1 block w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"
                                               placeholder="0.00">
                                        <input type="hidden" id="expenses_hidden" name="expenses">
                                    </div>
                                    @error('expenses')
                                        <p class="mt-1 text-sm text-red-600 dark:text-red-400">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>

                            <!-- Net Income Display -->
                            <div class="bg-blue-50 dark:bg-blue-900/20 rounded-lg p-4 border border-blue-200 dark:border-blue-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center">
                                        <svg class="w-5 h-5 text-blue-600 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                                        </svg>
                                        <span class="text-sm font-medium text-blue-800 dark:text-blue-200">Ingresos Disponibles:</span>
                                    </div>
                                    <span id="net-income" class="text-lg font-bold text-blue-900 dark:text-blue-100">$0.00</span>
                                </div>
                                <p class="text-xs text-blue-700 dark:text-blue-300 mt-1">
                                    Esta es tu capacidad de pago estimada (Ingresos - Gastos)
                                </p>
                            </div>

                            <!-- Form Actions -->
                            <div class="flex items-center justify-between pt-6 border-t border-gray-200 dark:border-gray-700">
                                <a href="{{ route('client.dashboard') }}" class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                                    </svg>
                                    Volver al Dashboard
                                </a>
                                
                                <button type="submit" id="submit-btn" disabled class="inline-flex items-center px-6 py-2 bg-gray-400 text-white text-sm font-medium rounded-md shadow-sm cursor-not-allowed transition-colors">
                                    Continuar al Paso 2
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

    <!-- JavaScript for Net Income Calculation and Validation -->
    <script>
        // Format currency input on blur
        function formatCurrencyInput(input) {
            let value = input.value.replace(/[^0-9.]/g, '');
            if (value && value !== '') {
                const numericValue = parseFloat(value);
                if (!isNaN(numericValue)) {
                    value = numericValue.toLocaleString('en-US', {
                        minimumFractionDigits: 2,
                        maximumFractionDigits: 2
                    });
                    input.value = value;
                }
            }
        }

        // Format currency while typing (without decimals)
        function formatCurrencyInputWhileTyping(input) {
            let value = input.value.replace(/[^0-9]/g, '');
            if (value === '') {
                input.value = '';
                return;
            }
            
            // Format with thousand separators
            const formattedValue = value.replace(/\B(?=(\d{3})+(?!\d))/g, ',');
            input.value = formattedValue;
        }

        // Get numeric value from formatted input
        function getNumericValue(formattedValue) {
            if (!formattedValue || formattedValue === '') {
                return 0;
            }
            const cleanValue = formattedValue.toString().replace(/,/g, '');
            return parseFloat(cleanValue) || 0;
        }

        function calculateNetIncome() {
            const incomeValue = document.getElementById('income').value;
            const expensesValue = document.getElementById('expenses').value;
            const income = getNumericValue(incomeValue);
            const expenses = getNumericValue(expensesValue);
            const netIncome = income - expenses;
            
            document.getElementById('net-income').textContent = '$' + netIncome.toLocaleString('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2
            });
            
            // Change color based on net income
            const netIncomeElement = document.getElementById('net-income');
            if (netIncome > 0) {
                netIncomeElement.className = 'text-lg font-bold text-green-900 dark:text-green-100';
            } else if (netIncome < 0) {
                netIncomeElement.className = 'text-lg font-bold text-red-900 dark:text-red-100';
            } else {
                netIncomeElement.className = 'text-lg font-bold text-blue-900 dark:text-blue-100';
            }
            
            validateForm();
        }

        // Add event listeners for formatting
        document.addEventListener('DOMContentLoaded', function() {
            const incomeInput = document.getElementById('income');
            const expensesInput = document.getElementById('expenses');

            // Format on blur
            incomeInput.addEventListener('blur', function() {
                formatCurrencyInput(this);
                calculateNetIncome();
            });

            expensesInput.addEventListener('blur', function() {
                formatCurrencyInput(this);
                calculateNetIncome();
            });

            // Calculate only, don't format while typing
            incomeInput.addEventListener('input', function() {
                const incomeHidden = document.getElementById('income_hidden');
                if (incomeHidden) {
                    incomeHidden.value = getNumericValue(incomeInput.value);
                }
                calculateNetIncome();
            });
            
            expensesInput.addEventListener('input', function() {
                const expensesHidden = document.getElementById('expenses_hidden');
                if (expensesHidden) {
                    expensesHidden.value = getNumericValue(expensesInput.value);
                }
                calculateNetIncome();
            });

        });

        function validateForm() {
            const employment = document.getElementById('employment').value;
            const companyName = document.getElementById('company_name').value.trim();
            const employmentYears = document.getElementById('employment_years').value;
            const income = getNumericValue(document.getElementById('income').value);
            const expenses = getNumericValue(document.getElementById('expenses').value);
            const submitBtn = document.getElementById('submit-btn');
            
            // Check all required fields
            const isValid = employment && 
                           companyName.length >= 2 && 
                           employmentYears !== '' && 
                           income > 0 && 
                           expenses >= 0 &&
                           (income - expenses) > 0; // Must have positive net income
            
            if (isValid) {
                submitBtn.disabled = false;
                submitBtn.className = 'inline-flex items-center px-6 py-2 bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 text-white text-sm font-medium rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors cursor-pointer';
            } else {
                submitBtn.disabled = true;
                submitBtn.className = 'inline-flex items-center px-6 py-2 bg-gray-400 text-white text-sm font-medium rounded-md shadow-sm cursor-not-allowed transition-colors';
            }
            
            // Show validation messages
            showValidationMessages(employment, companyName, employmentYears);
        }
        
        function showValidationMessages(employment, companyName, employmentYears) {
            const income = getNumericValue(document.getElementById('income').value);
            const expenses = getNumericValue(document.getElementById('expenses').value);
            // Clear previous messages
            document.querySelectorAll('.validation-message').forEach(el => el.remove());
            
            const netIncome = income - expenses;
            
            if (income > 0 && expenses >= 0 && netIncome <= 0) {
                const netIncomeDiv = document.getElementById('net-income').parentElement;
                const message = document.createElement('p');
                message.className = 'validation-message text-xs text-red-600 dark:text-red-400 mt-1';
                message.textContent = '⚠️ Tus ingresos deben ser mayores a tus gastos para poder solicitar un préstamo';
                netIncomeDiv.appendChild(message);
            }
            
            if (companyName && companyName.length < 2) {
                const companyField = document.getElementById('company_name');
                const message = document.createElement('p');
                message.className = 'validation-message text-xs text-red-600 dark:text-red-400 mt-1';
                message.textContent = 'El nombre de la empresa debe tener al menos 2 caracteres';
                companyField.parentElement.appendChild(message);
            }
        }

        // Add event listeners
        document.getElementById('income').addEventListener('input', calculateNetIncome);
        document.getElementById('expenses').addEventListener('input', calculateNetIncome);
        document.getElementById('employment').addEventListener('change', validateForm);
        document.getElementById('company_name').addEventListener('input', validateForm);
        document.getElementById('employment_years').addEventListener('change', validateForm);
        
        // Store original submit handler and add validation
        const form = document.querySelector('form');
        const originalSubmitHandler = form.onsubmit;
        
        form.addEventListener('submit', function(e) {
            const income = getNumericValue(document.getElementById('income').value);
            const expenses = getNumericValue(document.getElementById('expenses').value);
            
            // Validate income and expenses are greater than 0
            if (income <= 0) {
                e.preventDefault();
                alert('Los ingresos mensuales deben ser mayores a $0.00');
                return false;
            }
            
            if (expenses < 0) {
                e.preventDefault();
                alert('Los gastos mensuales no pueden ser negativos');
                return false;
            }
            
            // Update UPC hidden inputs before submission
            const incomeHidden = document.getElementById('income_hidden');
            const expensesHidden = document.getElementById('expenses_hidden');
            
            console.log('Setting hidden values:', {income, expenses});
            console.log('Hidden inputs found:', {incomeHidden, expensesHidden});
            
            if (incomeHidden) {
                incomeHidden.value = income;
                console.log('Income hidden value set to:', incomeHidden.value);
            }
            if (expensesHidden) {
                expensesHidden.value = expenses;
                console.log('Expenses hidden value set to:', expensesHidden.value);
            }
        });
        
        // Calculate on page load
        document.addEventListener('DOMContentLoaded', function() {
            const incomeInput = document.getElementById('income');
            const expensesInput = document.getElementById('expenses');
            const incomeHidden = document.getElementById('income_hidden');
            const expensesHidden = document.getElementById('expenses_hidden');
            
            // Initialize hidden inputs with current values
            if (incomeInput && incomeHidden) {
                incomeHidden.value = getNumericValue(incomeInput.value);
            }
            if (expensesInput && expensesHidden) {
                expensesHidden.value = getNumericValue(expensesInput.value);
            }
            
            calculateNetIncome();
            validateForm();
        });
    </script>
</x-app-layout>
