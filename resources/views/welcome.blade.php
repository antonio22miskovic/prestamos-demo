<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Préstamos Demo - Tu Crédito Rápido y Seguro</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="antialiased bg-gray-50 dark:bg-gray-900">
        <!-- Navigation -->
        <nav class="bg-white dark:bg-gray-800 shadow-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between h-16">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <h1 class="text-xl font-bold text-blue-600 dark:text-blue-400">
                                💰 Préstamos Demo
                            </h1>
                        </div>
                    </div>
                    
            @if (Route::has('login'))
                        <div class="flex items-center space-x-4">
                    @auth
                                <a href="{{ url('/dashboard') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                                    Dashboard
                                </a>
                    @else
                                <a href="{{ route('login') }}" class="text-gray-700 dark:text-gray-300 hover:text-blue-600 dark:hover:text-blue-400 px-3 py-2 rounded-md text-sm font-medium">
                                    Iniciar sesión
                                </a>
                        @if (Route::has('register'))
                                    <a href="{{ route('register') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-md text-sm font-medium">
                                        Registrarse
                                    </a>
                        @endif
                    @endauth
                </div>
            @endif
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <div class="relative overflow-hidden">
            <div class="max-w-7xl mx-auto">
                <div class="relative z-10 pb-8 bg-gray-50 dark:bg-gray-900 sm:pb-16 md:pb-20 lg:max-w-2xl lg:w-full lg:pb-28 xl:pb-32 lg:pr-8 xl:pr-16">
                    <main class="mt-10 mx-auto max-w-7xl px-4 sm:mt-12 sm:px-6 md:mt-16 lg:mt-20 lg:px-8 xl:mt-28 lg:pr-16 xl:pr-24">
                        <div class="sm:text-center lg:text-left">
                            <h1 class="text-4xl tracking-tight font-extrabold text-gray-900 dark:text-white sm:text-5xl md:text-6xl">
                                <span class="block xl:inline">Tu crédito</span>
                                <span class="block text-blue-600 dark:text-blue-400 xl:inline">rápido y seguro</span>
                            </h1>
                            <p class="mt-3 text-base text-gray-500 dark:text-gray-400 sm:mt-5 sm:text-lg sm:max-w-xl sm:mx-auto md:mt-5 md:text-xl lg:mx-0 lg:max-w-lg">
                                Solicita tu préstamo en minutos con nuestro proceso 100% digital. Evaluación automática, documentos seguros y respuesta inmediata.
                            </p>
                            <div class="mt-5 sm:mt-8 sm:flex sm:justify-center lg:justify-start">
                                <div class="rounded-md shadow">
                                    <a href="{{ route('register') }}" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 md:py-4 md:text-lg md:px-10">
                                        Solicitar préstamo
                                    </a>
                                </div>
                                <div class="mt-3 sm:mt-0 sm:ml-3">
                                    <a href="#features" class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-blue-700 bg-blue-100 hover:bg-blue-200 md:py-4 md:text-lg md:px-10">
                                        Conocer más
                                    </a>
                                </div>
                            </div>
                        </div>
                    </main>
                </div>
            </div>
            <div class="lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                <div class="h-56 w-full bg-gradient-to-r from-blue-400 to-blue-600 sm:h-72 md:h-96 lg:w-full lg:h-full flex items-center justify-center relative overflow-hidden">
                    <!-- Background Pattern -->
                    <div class="absolute inset-0 opacity-10">
                        <svg class="w-full h-full" viewBox="0 0 400 400" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <defs>
                                <pattern id="grid" width="40" height="40" patternUnits="userSpaceOnUse">
                                    <path d="M 40 0 L 0 0 0 40" fill="none" stroke="white" stroke-width="1"/>
                                </pattern>
                            </defs>
                            <rect width="100%" height="100%" fill="url(#grid)" />
                    </svg>
                </div>

                    <!-- Main Content -->
                    <div class="text-center text-white relative z-10 px-4 lg:px-8">
                        <!-- Credit Card Visual -->
                        <div class="mb-6 relative">
                            <div class="bg-white bg-opacity-20 backdrop-blur-sm rounded-2xl p-6 w-64 mx-auto shadow-2xl transform rotate-3 hover:rotate-0 transition-transform duration-300">
                                <div class="flex justify-between items-start mb-4">
                                    <div class="w-12 h-8 bg-yellow-300 rounded"></div>
                                    <svg class="w-8 h-8" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z"/>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-xs opacity-75 mb-1">CRÉDITO APROBADO</div>
                                    <div class="text-lg font-bold">$25,000.00</div>
                                    <div class="text-xs opacity-75 mt-2">PRÉSTAMOS DEMO</div>
                                </div>
                            </div>
                            </div>

                        <h3 class="text-2xl font-bold mb-2">Proceso 100% Digital</h3>
                        <p class="text-blue-100 mb-4">Sin papeleos, sin filas, sin complicaciones</p>
                        
                        <!-- Feature Icons -->
                        <div class="flex justify-center space-x-6 mt-4">
                            <div class="text-center">
                                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                                    </svg>
                                </div>
                                <div class="text-xs">Rápido</div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12,1L3,5V11C3,16.55 6.84,21.74 12,23C17.16,21.74 21,16.55 21,11V5L12,1M10,17L6,13L7.41,11.59L10,14.17L16.59,7.58L18,9L10,17Z"/>
                                    </svg>
                                </div>
                                <div class="text-xs">Seguro</div>
                            </div>
                            <div class="text-center">
                                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mb-2">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M7,2V4H8V18A4,4 0 0,0 12,22A4,4 0 0,0 16,18V4H17V2H7M11,16C10.4,16 10,15.6 10,15C10,14.4 10.4,14 11,14C11.6,14 12,14.4 12,15C12,15.6 11.6,16 11,16M13,12C12.4,12 12,11.6 12,11C12,10.4 12.4,10 13,10C13.6,10 14,10.4 14,11C14,11.6 13.6,12 13,12M14,7H10V9H14V7Z"/>
                                    </svg>
                                </div>
                                <div class="text-xs">Fácil</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Features Section -->
        <div id="features" class="py-12 bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 dark:text-blue-400 font-semibold tracking-wide uppercase">Características</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        ¿Por qué elegir Préstamos Demo?
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-10 sm:grid-cols-2 lg:grid-cols-3">
                        <!-- Feature 1 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg leading-6 font-medium text-gray-900 dark:text-white">Respuesta Rápida</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Evaluación automática en minutos. No esperes días para conocer el resultado.
                            </p>
                        </div>

                        <!-- Feature 2 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg leading-6 font-medium text-gray-900 dark:text-white">100% Seguro</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Tus datos están protegidos con encriptación de nivel bancario.
                            </p>
                        </div>

                        <!-- Feature 3 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-12 w-12 rounded-md bg-blue-500 text-white mx-auto">
                                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1" />
                                </svg>
                            </div>
                            <h3 class="mt-4 text-lg leading-6 font-medium text-gray-900 dark:text-white">Tasas Competitivas</h3>
                            <p class="mt-2 text-base text-gray-500 dark:text-gray-400">
                                Ofrecemos las mejores tasas del mercado adaptadas a tu perfil crediticio.
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Process Section -->
        <div class="bg-gray-50 dark:bg-gray-900 py-12">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="lg:text-center">
                    <h2 class="text-base text-blue-600 dark:text-blue-400 font-semibold tracking-wide uppercase">Proceso</h2>
                    <p class="mt-2 text-3xl leading-8 font-extrabold tracking-tight text-gray-900 dark:text-white sm:text-4xl">
                        Obtén tu préstamo en 4 pasos
                    </p>
                </div>

                <div class="mt-10">
                    <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-4">
                        <!-- Step 1 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mx-auto text-xl font-bold">
                                1
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Regístrate</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Crea tu cuenta con tu email y teléfono
                            </p>
                        </div>

                        <!-- Step 2 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mx-auto text-xl font-bold">
                                2
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Completa tu solicitud</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Propósito, monto, plazo y datos personales
                            </p>
                        </div>

                        <!-- Step 3 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mx-auto text-xl font-bold">
                                3
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Sube documentos</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                ID, comprobante de ingresos y domicilio
                            </p>
                </div>

                        <!-- Step 4 -->
                        <div class="text-center">
                            <div class="flex items-center justify-center h-16 w-16 rounded-full bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-400 mx-auto text-xl font-bold">
                                4
                            </div>
                            <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">Recibe tu crédito</h3>
                            <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                                Firma el contrato y recibe el desembolso
                            </p>
                        </div>
                    </div>
                </div>
            </div>
                    </div>

        <!-- Demo Section -->
        <div class="bg-blue-600 dark:bg-blue-700">
            <div class="max-w-7xl mx-auto py-12 px-4 sm:px-6 lg:py-16 lg:px-8 lg:flex lg:items-center lg:justify-between">
                <h2 class="text-3xl font-extrabold tracking-tight text-white sm:text-4xl">
                    <span class="block">¿Listo para comenzar?</span>
                    <span class="block text-blue-200">Prueba nuestro sistema demo.</span>
                </h2>
                <div class="mt-8 flex lg:mt-0 lg:flex-shrink-0">
                    <div class="inline-flex rounded-md shadow">
                        <a href="{{ route('register') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-blue-600 bg-white hover:bg-blue-50">
                            Comenzar ahora
                        </a>
                    </div>
                    <div class="ml-3 inline-flex rounded-md shadow">
                        <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-blue-500 hover:bg-blue-400">
                            Ya tengo cuenta
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Footer -->
        <footer class="bg-white dark:bg-gray-800">
            <div class="max-w-7xl mx-auto py-8 px-4 sm:px-6 lg:px-8">
                <div class="text-center">
                    <p class="text-gray-500 dark:text-gray-400 text-sm">
                        © {{ date('Y') }} Préstamos Demo. Sistema de demostración construido con Laravel {{ Illuminate\Foundation\Application::VERSION }}.
                    </p>
                </div>
            </div>
        </footer>
    </body>
</html>
