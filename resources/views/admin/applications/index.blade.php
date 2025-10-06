@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">Gestión de Solicitudes</h1>
            <p class="mt-2 text-sm text-gray-700 dark:text-gray-300">Administra y evalúa las solicitudes de préstamos</p>
        </div>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">
        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-blue-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Total</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white" data-stat="total">{{ number_format($stats['total']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-yellow-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Pendientes</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white" data-stat="pending">{{ number_format($stats['pending']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-green-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Aprobadas</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white" data-stat="approved">{{ number_format($stats['approved']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>

        <div class="bg-white dark:bg-gray-800 overflow-hidden shadow rounded-lg">
            <div class="p-5">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-8 h-8 bg-red-500 rounded-full flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="ml-5 w-0 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400 truncate">Rechazadas</dt>
                            <dd class="text-lg font-medium text-gray-900 dark:text-white" data-stat="rejected">{{ number_format($stats['rejected']) }}</dd>
                        </dl>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-4 py-5 sm:p-6">
            <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Filtros</h3>
            <form id="applicationsFilterForm" method="GET" action="{{ route('admin.applications.index') }}" class="space-y-4">
                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">
                    <!-- Status Filter -->
                    <div>
                        <label for="status" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Estado</label>
                        <select name="status" id="status" class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                            <option value="">Todos los estados</option>
                            <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Borrador</option>
                            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>Pendiente</option>
                            <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rechazada</option>
                        </select>
                    </div>

                    <!-- Amount Range -->
                    <div>
                        <label for="amount_min" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto Mínimo</label>
                        <input type="number" name="amount_min" id="amount_min" value="{{ request('amount_min') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Ej: 10000">
                    </div>

                    <div>
                        <label for="amount_max" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Monto Máximo</label>
                        <input type="number" name="amount_max" id="amount_max" value="{{ request('amount_max') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Ej: 100000">
                    </div>

                    <!-- Search -->
                    <div>
                        <label for="search" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Buscar Cliente</label>
                        <input type="text" name="search" id="search" value="{{ request('search') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm" 
                               placeholder="Nombre o email">
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                    <!-- Date Range -->
                    <div>
                        <label for="date_from" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Desde</label>
                        <input type="date" name="date_from" id="date_from" value="{{ request('date_from') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>

                    <div>
                        <label for="date_to" class="block text-sm font-medium text-gray-700 dark:text-gray-300">Fecha Hasta</label>
                        <input type="date" name="date_to" id="date_to" value="{{ request('date_to') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 dark:border-gray-600 dark:bg-gray-700 dark:text-white shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                    </div>
                </div>

                <div class="flex justify-end space-x-3">
                    <a href="{{ route('admin.applications.index') }}" 
                       class="bg-white dark:bg-gray-700 py-2 px-4 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm text-sm font-medium text-gray-700 dark:text-gray-300 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Limpiar
                    </a>
                    <button type="submit" 
                            class="bg-gradient-to-r from-blue-600 to-blue-700 py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        Aplicar Filtros
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Applications Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white">Solicitudes de Préstamos</h3>
        </div>
        
        <!-- Loading indicator -->
        <div id="applicationsLoading" class="hidden px-6 py-8 text-center">
            <div class="inline-flex items-center">
                <svg class="animate-spin -ml-1 mr-3 h-5 w-5 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>
                <span class="text-gray-600 dark:text-gray-400">Cargando...</span>
            </div>
        </div>
        
        <div id="applicationsTableContainer" class="overflow-hidden">
            @include('admin.applications.partials.table', ['applications' => $applications])
        </div>

        <!-- Pagination -->
        <div id="applicationsPagination" class="bg-white dark:bg-gray-800 px-4 py-3 border-t border-gray-200 dark:border-gray-700 sm:px-6">
            @if($applications->hasPages())
                {{ $applications->links() }}
            @endif
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('applicationsFilterForm');
    const tableContainer = document.getElementById('applicationsTableContainer');
    const paginationContainer = document.getElementById('applicationsPagination');
    const loadingIndicator = document.getElementById('applicationsLoading');
    
    // Function to update stats
    function updateStats(stats) {
        const statsElements = {
            total: document.querySelector('[data-stat="total"]'),
            pending: document.querySelector('[data-stat="pending"]'),
            approved: document.querySelector('[data-stat="approved"]'),
            rejected: document.querySelector('[data-stat="rejected"]')
        };
        
        Object.keys(statsElements).forEach(key => {
            if (statsElements[key] && stats[key] !== undefined) {
                statsElements[key].textContent = new Intl.NumberFormat().format(stats[key]);
            }
        });
    }
    
    // Function to load applications
    function loadApplications(params = {}) {
        loadingIndicator.classList.remove('hidden');
        tableContainer.style.opacity = '0.5';
        
        const url = new URL('{{ route("admin.applications.data") }}');
        Object.keys(params).forEach(key => {
            if (params[key]) url.searchParams.append(key, params[key]);
        });
        
        fetch(url, {
            method: 'GET',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json'
            }
        })
        .then(response => response.json())
        .then(data => {
            tableContainer.innerHTML = data.html;
            paginationContainer.innerHTML = data.pagination;
            updateStats(data.stats);
            
            // Update URL without page reload
            const newUrl = new URL(window.location);
            Object.keys(params).forEach(key => {
                if (params[key]) {
                    newUrl.searchParams.set(key, params[key]);
                } else {
                    newUrl.searchParams.delete(key);
                }
            });
            window.history.pushState({}, '', newUrl);
        })
        .catch(error => {
            console.error('Error:', error);
            // Fallback to normal form submission
            form.submit();
        })
        .finally(() => {
            loadingIndicator.classList.add('hidden');
            tableContainer.style.opacity = '1';
        });
    }
    
    // Handle form submission
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(form);
        const params = {};
        
        for (let [key, value] of formData.entries()) {
            if (value.trim()) params[key] = value;
        }
        
        loadApplications(params);
    });
    
    // Handle input changes for real-time filtering (optional)
    const inputs = form.querySelectorAll('input, select');
    let timeout;
    
    inputs.forEach(input => {
        input.addEventListener('input', function() {
            clearTimeout(timeout);
            timeout = setTimeout(() => {
                form.dispatchEvent(new Event('submit'));
            }, 500); // 500ms delay for real-time filtering
        });
    });
    
    // Handle pagination clicks
    document.addEventListener('click', function(e) {
        if (e.target.closest('#applicationsPagination a')) {
            e.preventDefault();
            const link = e.target.closest('a');
            const url = new URL(link.href);
            const params = {};
            
            // Get current form data
            const formData = new FormData(form);
            for (let [key, value] of formData.entries()) {
                if (value.trim()) params[key] = value;
            }
            
            // Add page parameter
            const page = url.searchParams.get('page');
            if (page) params.page = page;
            
            loadApplications(params);
        }
    });
});
</script>
@endsection
