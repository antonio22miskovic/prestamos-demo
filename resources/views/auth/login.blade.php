<x-guest-layout>
    <div class="min-h-screen flex">
        <!-- Left Side - Visual Content -->
        <div class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-blue-400 via-blue-500 to-blue-600 flex-col justify-center items-center relative overflow-hidden">
            <!-- Background Pattern -->
            <div class="absolute inset-0 opacity-10">
                <svg class="w-full h-full" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <defs>
                        <pattern id="grid-login" width="40" height="40" patternUnits="userSpaceOnUse">
                            <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                        </pattern>
                    </defs>
                    <rect width="100%" height="100%" fill="url(#grid-login)" />
                </svg>
            </div>
            
            <!-- Content -->
            <div class="text-center text-white relative z-10 px-8">
                <!-- Logo/Brand -->
                <div class="mb-8">
                    <div class="w-20 h-20 bg-white bg-opacity-20 backdrop-blur-sm rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-10 h-10" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                        </svg>
                    </div>
                    <h1 class="text-3xl font-bold mb-2">💰 Préstamos Demo</h1>
                    <p class="text-blue-100 text-lg">Tu crédito rápido y seguro</p>
                </div>

                <!-- Features -->
                <div class="space-y-6 mb-8">
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">Proceso Rápido</h3>
                            <p class="text-blue-100 text-sm">Evaluación en minutos</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">100% Seguro</h3>
                            <p class="text-blue-100 text-sm">Datos protegidos</p>
                        </div>
                    </div>
                    
                    <div class="flex items-center space-x-4">
                        <div class="w-12 h-12 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                            </svg>
                        </div>
                        <div class="text-left">
                            <h3 class="font-semibold">Tasas Competitivas</h3>
                            <p class="text-blue-100 text-sm">Mejores condiciones</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Side - Login Form -->
        <div class="flex-1 flex flex-col justify-center py-12 px-4 sm:px-6 lg:px-20 xl:px-24 bg-white dark:bg-gray-900">
            <div class="mx-auto w-full max-w-sm lg:w-96">
                <!-- Mobile Logo -->
                <div class="lg:hidden text-center mb-8">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                        </svg>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900 dark:text-gray-100">💰 Préstamos Demo</h1>
                </div>

                <div class="text-center lg:text-left">
                    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100">
                        Iniciar sesión
                    </h2>
                    <p class="mt-2 text-sm text-gray-600 dark:text-gray-400">
                        Accede a tu cuenta para gestionar tus préstamos
                    </p>
                </div>

                <!-- Session Status -->
                <x-auth-session-status class="mt-4" :status="session('status')" />

                <!-- Demo Users Info -->
                <div class="mt-6 p-4 bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-800 rounded-lg">
                    <div class="flex items-center justify-between mb-3">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                            </svg>
                            <h3 class="text-sm font-semibold text-blue-800 dark:text-blue-200">
                                🧪 Usuarios de prueba
                            </h3>
                        </div>
                        <div class="text-xs text-gray-500 dark:text-gray-400">
                            Click para autocompletar ↓
                        </div>
                    </div>
                    <div class="space-y-2">
                        <!-- Admin User -->
                        <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-gray-800 border border-blue-100 dark:border-blue-800 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors cursor-pointer group" onclick="fillCredentials('admin@prestamos-demo.com', 'admin123')">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Admin</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">admin@prestamos-demo.com</div>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                        
                        <!-- Client User -->
                        <div class="flex items-center justify-between p-2 rounded bg-white dark:bg-gray-800 border border-blue-100 dark:border-blue-800 hover:bg-blue-50 dark:hover:bg-blue-900/30 transition-colors cursor-pointer group" onclick="fillCredentials('client@prestamos-demo.com', 'client123')">
                            <div class="flex items-center space-x-3">
                                <div class="w-6 h-6 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center">
                                    <svg class="w-3 h-3 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-xs font-medium text-gray-800 dark:text-gray-200">Cliente</div>
                                    <div class="text-xs text-gray-600 dark:text-gray-400">client@prestamos-demo.com</div>
                                </div>
                            </div>
                            <svg class="w-4 h-4 text-blue-500 opacity-0 group-hover:opacity-100 transition-opacity" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        </div>
                    </div>
                </div>

                <form method="POST" action="{{ route('login') }}" class="mt-8 space-y-6">
                    @csrf

                    <!-- Email Address -->
                    <div>
                        <x-input-label for="email" :value="__('Correo electrónico')" />
                        <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" placeholder="ejemplo@correo.com" />
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <x-input-label for="password" :value="__('Contraseña')" />
                        <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="current-password" />
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me and Forgot Password -->
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" class="rounded dark:bg-gray-900 border-gray-300 dark:border-gray-700 text-blue-600 shadow-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:focus:ring-offset-gray-800" name="remember">
                            <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Recordarme') }}</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline" href="{{ route('password.request') }}">
                                {{ __('¿Olvidaste tu contraseña?') }}
                            </a>
                        @endif
                    </div>

                    <div>
                        <x-primary-button class="w-full justify-center bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800">
                            {{ __('Iniciar sesión') }}
                        </x-primary-button>
                    </div>

                    <div class="text-center">
                        <span class="text-sm text-gray-600 dark:text-gray-400">
                            ¿No tienes cuenta?
                        </span>
                        <a class="text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 underline ml-1 font-medium" href="{{ route('register') }}">
                            {{ __('Regístrate aquí') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function fillCredentials(email, password) {
            // Llenar los campos del formulario
            document.getElementById('email').value = email;
            document.getElementById('password').value = password;
            
            // Agregar efecto visual de confirmación
            const emailField = document.getElementById('email');
            const passwordField = document.getElementById('password');
            
            // Efecto de highlight
            emailField.classList.add('ring-2', 'ring-green-500', 'ring-opacity-50');
            passwordField.classList.add('ring-2', 'ring-green-500', 'ring-opacity-50');
            
            // Remover el efecto después de 1.5 segundos
            setTimeout(() => {
                emailField.classList.remove('ring-2', 'ring-green-500', 'ring-opacity-50');
                passwordField.classList.remove('ring-2', 'ring-green-500', 'ring-opacity-50');
            }, 1500);
            
            // Enfocar el botón de login
            setTimeout(() => {
                document.querySelector('button[type="submit"]').focus();
            }, 100);
        }
    </script>
</x-guest-layout>
