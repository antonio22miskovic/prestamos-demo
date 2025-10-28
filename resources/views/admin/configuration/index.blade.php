@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Configuración del Sistema</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Gestiona las configuraciones generales de la plataforma</p>
        </div>
    </div>

    <!-- Success Message -->
    @if(session('success'))
    <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700 rounded-lg p-4">
        <div class="flex items-center">
            <svg class="w-5 h-5 text-green-600 dark:text-green-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            <p class="text-sm text-green-800 dark:text-green-300">{{ session('success') }}</p>
        </div>
    </div>
    @endif

    <!-- Configuration Form -->
    <form action="{{ route('admin.configuration.update') }}" method="POST">
        @csrf
        @method('PUT')
        
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-4 py-5 sm:p-6 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Configuración de Tasas de Interés</h3>
                <p class="text-sm text-gray-500 dark:text-gray-400">
                    Configura las tasas de interés por tipo de préstamo. Estos valores se utilizan para calcular el monto total de los préstamos.
                </p>
            </div>

        <div class="px-4 py-5 sm:p-6 border-t border-gray-200 dark:border-gray-700">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @php
                    $interestTypes = [
                        'personal' => 'Personal',
                        'business' => 'Empresarial',
                        'home_improvement' => 'Mejora del Hogar',
                        'medical' => 'Médico',
                        'education' => 'Educación',
                        'vehicle' => 'Vehículo',
                        'debt_consolidation' => 'Consolidación de Deuda',
                        'emergency' => 'Emergencia'
                    ];
                @endphp

                @foreach($interestTypes as $key => $label)
                <div>
                    <label for="interest_{{ $key }}" class="block text-sm font-medium text-gray-700 dark:text-gray-300">
                        {{ $label }}
                    </label>
                    <div class="mt-1 relative">
                        <input type="number" 
                               name="interest_rates[{{ $key }}]"
                               id="interest_{{ $key }}" 
                               value="{{ $config['interest_rates'][$key] ?? 0 }}" 
                               step="0.01" 
                               min="0" 
                               max="100"
                               class="block w-full rounded-md border-gray-300 dark:border-gray-600 shadow-sm focus:border-blue-500 focus:ring-blue-500 dark:bg-gray-700 dark:text-white sm:text-sm">
                        <span class="absolute inset-y-0 right-0 pr-3 flex items-center pointer-events-none text-gray-500">%</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
        <!-- Action Buttons -->
        <div class="px-4 py-4 bg-gray-50 dark:bg-gray-900 flex justify-end space-x-3 border-t border-gray-200 dark:border-gray-700">
            <a href="{{ route('admin.applications.index') }}" 
               class="inline-flex items-center px-4 py-2 border border-gray-300 dark:border-gray-600 shadow-sm text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Cancelar
            </a>
            <button type="submit" 
                    class="inline-flex items-center px-6 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                Guardar Cambios
            </button>
        </div>
        </div>
    </form>

    <!-- Info Box -->
    <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
        <div class="flex">
            <svg class="w-5 h-5 text-blue-600 dark:text-blue-400 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
            </svg>
            <div class="flex-1 text-sm text-blue-800 dark:text-blue-300">
                <p class="font-medium">Nota importante</p>
                <p class="mt-1">Los cambios en las tasas de interés se aplicarán a los préstamos aprobados después de guardar. Los préstamos existentes mantendrán sus tasas originales.</p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Auto-hide success message after 5 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.querySelector('.bg-green-50, .bg-green-900');
        if (successMessage) {
            setTimeout(function() {
                successMessage.style.transition = 'opacity 0.5s';
                successMessage.style.opacity = '0';
                setTimeout(function() {
                    successMessage.remove();
                }, 500);
            }, 5000);
        }
    });
</script>
@endpush
@endsection
