<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Visual Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 flex-col justify-center items-center relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid-register" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-register)" />
                </svg>
            </div>
            
            <!-- Content -->
            <div class="text-center text-white relative z-10 px-8">
                <!-- Logo/Brand -->
                <div class="mb-8">
                    <div class="w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">💰 Préstamos Demo</h1>
                    <p class="text-blue-100 text-lg">Tu crédito rápido y seguro</p>
                </div>

                <!-- Process Steps -->
                <div class="space-y-4 mb-8">
                    <h3 class="text-xl font-semibold mb-4">Proceso simple en 4 pasos:</h3>
                    
                    <div class="flex items-center space-x-3 text-left">
                        <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-bold">1</div>
                        <div>
                            <p class="font-medium">Regístrate</p>
                            <p class="text-blue-100 text-sm">Crea tu cuenta</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-left">
                        <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-bold">2</div>
                        <div>
                            <p class="font-medium">Solicita</p>
                            <p class="text-blue-100 text-sm">Completa tu solicitud</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-left">
                        <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-bold">3</div>
                        <div>
                            <p class="font-medium">Documenta</p>
                            <p class="text-blue-100 text-sm">Sube tus documentos</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-3 text-left">
                        <div class="w-8 h-8 bg-white bg-opacity-30 rounded-full flex items-center justify-center text-sm font-bold">4</div>
                        <div>
                            <p class="font-medium">Recibe</p>
                            <p class="text-blue-100 text-sm">Obtén tu crédito</p>
                        </div>
                    </div>
                </div>

                <!-- Security Badge -->
                <div class="flex items-center justify-center space-x-2 text-blue-100">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                    </svg>
                    <span class="text-sm">Datos protegidos con encriptación SSL</span>
                </div>
            </div>
        </div>

        <!-- Right Side - Register Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white dark:bg-gray-900">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">💰 Préstamos Demo</h1>
                </div>

                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Crear cuenta
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Regístrate para solicitar tu préstamo de forma rápida y segura
                    </p>
                </div>

                <form method="POST" action="{{ route('register') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Name -->
                    <div>
                        <x-input-label for="name" :value="__('Nombre completo')" />
                        <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" placeholder="Ingresa tu nombre completo" />
                        <x-input-error :messages="$errors->get('name')" class="mt-2" />
                    </div>

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" placeholder="ejemplo@correo.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Phone -->
                    <div>
                        <x-input-label for="phone" :value="__('Teléfono')" />
                        <x-text-input id="phone" class="block mt-1 w-full" type="tel" name="phone" :value="old('phone')" required placeholder="+51 999 999 999" />
                        <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            <svg class="w-3 h-3 inline mr-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            Usaremos este número para contactarte sobre tu solicitud
                        </p>
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                            Mínimo 8 caracteres
                        </p>
                    </div>

                    <!-- Confirm Password -->
                    <div>
                        <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />
                        <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                        <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                    </div>

                    <!-- Terms and Conditions -->
                    <div>
                        <label for="terms" class="inline-flex items-start">
                            <input id="terms" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800 mt-1" name="terms" required>
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">
                                Acepto los 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline font-medium">términos y condiciones</a> 
                                y la 
                                <a href="#" class="text-blue-600 hover:text-blue-800 underline font-medium">política de privacidad</a>
                            </span>
                        </label>
                        <x-input-error :messages="$errors->get('terms')" class="mt-2" />
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                            <svg class="w-5 h-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                            {{ __('Crear mi cuenta') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            ¿Ya tienes cuenta?
                        </span>
                        <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline ml-1 font-medium" href="{{ route('login') }}">
                            {{ __('Inicia sesión aquí') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-guest-layout>
