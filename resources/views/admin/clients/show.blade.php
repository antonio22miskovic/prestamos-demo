@extends('layouts.admin')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="sm:flex sm:items-center sm:justify-between">
        <div>
            <nav class="flex" aria-label="Breadcrumb">
                <ol class="flex items-center space-x-4">
                    <li>
            <a href="{{ route('admin.clients.index') }}" class="text-gray-400 hover:text-gray-500 dark:text-gray-500 dark:hover:text-gray-400">
                <span>Clientes</span>
            </a>
                    </li>
                    <li>
                        <div class="flex items-center">
                            <svg class="flex-shrink-0 h-5 w-5 text-gray-300" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 111.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd" />
                            </svg>
                            <span class="ml-4 text-sm font-medium text-gray-500 dark:text-gray-400">{{ $client->user->name }}</span>
                        </div>
                    </li>
                </ol>
            </nav>
            <h1 class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">Perfil del Cliente</h1>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Main Content -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Client Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white dark:text-white mb-4">Información Personal</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->name }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Email</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->email }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->user->phone ?: 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Documento</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $client->document_type ?: 'No especificado' }}
                                {{ $client->document_number ?: '' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Situación Laboral</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $client->employment ?: 'No especificado' }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $client->created_at->format('d/m/Y H:i') }}
                                ({{ $client->created_at->diffForHumans() }})
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Financial Information -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white dark:text-white mb-4">Información Financiera</h3>
                    <dl class="grid grid-cols-1 gap-x-4 gap-y-6 sm:grid-cols-2">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                ${{ number_format($client->income, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Gastos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                ${{ number_format($client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Capacidad de Pago</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white font-semibold">
                                ${{ number_format($client->income - $client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ratio Ingreso/Gasto</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($client->income > 0)
                                    {{ number_format(($client->expenses / $client->income) * 100, 1) }}%
                                @else
                                    N/A
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Active Loans -->
            @if($client->loans->where('status', 'active')->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Créditos Activos</h3>
                        <div class="space-y-4">
                            @foreach($client->loans->where('status', 'active') as $loan)
                                <div class="border border-gray-200 rounded-lg p-4">
                                    <div class="flex items-center justify-between">
                                        <div>
                                            <h4 class="text-sm font-medium text-gray-900">Préstamo #{{ $loan->id }}</h4>
                                            <p class="text-sm text-gray-500">
                                                Aprobado el {{ $loan->approved_at->format('d/m/Y') }}
                                            </p>
                                        </div>
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Activo
                                        </span>
                                    </div>
                                    <dl class="mt-4 grid grid-cols-2 gap-4 sm:grid-cols-4">
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Monto Original</dt>
                                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                                ${{ number_format($loan->amount, 0, ',', '.') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Saldo Pendiente</dt>
                                            <dd class="mt-1 text-sm font-semibold text-red-600">
                                                ${{ number_format($loan->remaining_balance, 0, ',', '.') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Cuota Mensual</dt>
                                            <dd class="mt-1 text-sm font-semibold text-gray-900">
                                                ${{ number_format($loan->monthly_fee, 0, ',', '.') }}
                                            </dd>
                                        </div>
                                        <div>
                                            <dt class="text-xs font-medium text-gray-500">Tasa Interés</dt>
                                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                                {{ number_format($loan->interest_rate * 100, 2) }}%
                                            </dd>
                                        </div>
                                    </dl>
                                    <!-- Progress bar -->
                                    @php
                                        $progress = (($loan->amount - $loan->remaining_balance) / $loan->amount) * 100;
                                    @endphp
                                    <div class="mt-4">
                                        <div class="flex items-center justify-between text-xs">
                                            <span class="text-gray-500">Progreso de pago</span>
                                            <span class="font-medium text-gray-900">{{ number_format($progress, 1) }}%</span>
                                        </div>
                                        <div class="mt-1 w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $progress }}%"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endif

            <!-- Loan History -->
            @if($client->loans->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Historial de Préstamos</h3>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                                <thead class="bg-gray-50 dark:bg-gray-700">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">ID</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Monto</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
                                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Fecha</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                                    @foreach($client->loans as $loan)
                                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                                                #{{ $loan->id }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                                                ${{ number_format($loan->amount, 0, ',', '.') }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                @php
                                                    $statusClasses = [
                                                        'approved' => 'bg-blue-100 text-blue-800',
                                                        'active' => 'bg-green-100 text-green-800',
                                                        'paid' => 'bg-purple-100 text-purple-800',
                                                        'defaulted' => 'bg-red-100 text-red-800',
                                                    ];
                                                @endphp
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $statusClasses[$loan->status] ?? 'bg-gray-100 text-gray-800' }}">
                                                    {{ ucfirst($loan->status) }}
                                                </span>
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500 dark:text-gray-400">
                                                {{ $loan->approved_at ? $loan->approved_at->format('d/m/Y') : $loan->created_at->format('d/m/Y') }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Recent Applications -->
            @if($client->loanApplications->count() > 0)
                <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Solicitudes Recientes</h3>
                        <div class="space-y-3">
                            @foreach($client->loanApplications as $application)
                                <div class="flex items-center justify-between p-3 border border-gray-200 rounded-lg">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900">
                                            Solicitud #{{ $application->id }}
                                        </p>
                                        <p class="text-sm text-gray-500">
                                            ${{ number_format($application->amount, 0, ',', '.') }} • 
                                            {{ $application->term_months }} meses • 
                                            {{ $application->created_at->format('d/m/Y') }}
                                        </p>
                                    </div>
                                    <div class="flex items-center space-x-2">
                                        @php
                                            $statusClasses = [
                                                'draft' => 'bg-gray-100 text-gray-800',
                                                'pending' => 'bg-yellow-100 text-yellow-800',
                                                'approved' => 'bg-green-100 text-green-800',
                                                'rejected' => 'bg-red-100 text-red-800',
                                            ];
                                            $statusLabels = [
                                                'draft' => 'Borrador',
                                                'pending' => 'Pendiente',
                                                'approved' => 'Aprobada',
                                                'rejected' => 'Rechazada',
                                            ];
                                        @endphp
                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$application->status] ?? 'bg-gray-100 text-gray-800' }}">
                                            {{ $statusLabels[$application->status] ?? ucfirst($application->status) }}
                                        </span>
                                        <a href="{{ route('admin.applications.show', $application) }}" 
                                           class="text-indigo-600 hover:text-indigo-900 text-sm">
                                            Ver
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
            <!-- Client Stats -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Estadísticas del Cliente</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Prestado</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                ${{ number_format($clientStats['total_borrowed'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Total Pagado</dt>
                            <dd class="mt-1 text-lg font-semibold text-green-600">
                                ${{ number_format($clientStats['total_paid'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Deuda Actual</dt>
                            <dd class="mt-1 text-lg font-semibold text-red-600">
                                ${{ number_format($clientStats['current_debt'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Cuotas Mensuales</dt>
                            <dd class="mt-1 text-lg font-semibold text-gray-900">
                                ${{ number_format($clientStats['monthly_payments'], 0, ',', '.') }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Préstamos Totales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientStats['loan_count'] }}</dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Solicitudes Totales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">{{ $clientStats['application_count'] }}</dd>
                        </div>
                    </dl>
                </div>
            </div>

            <!-- Risk Assessment -->
            <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
                <div class="px-4 py-5 sm:p-6">
                    <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white mb-4">Evaluación de Riesgo</h3>
                    <dl class="space-y-3">
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Ratio Deuda/Ingreso</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @php
                                    $debtRatio = $client->income > 0 
                                        ? ($clientStats['monthly_payments'] / $client->income) * 100 
                                        : 0;
                                @endphp
                                {{ number_format($debtRatio, 1) }}%
                                @if($debtRatio > 30)
                                    <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                        Alto Riesgo
                                    </span>
                                @elseif($debtRatio > 20)
                                    <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                        Riesgo Moderado
                                    </span>
                                @else
                                    <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                        Bajo Riesgo
                                    </span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Capacidad de Pago Restante</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @php
                                    $remainingCapacity = ($client->income - $client->expenses) - $clientStats['monthly_payments'];
                                @endphp
                                ${{ number_format($remainingCapacity, 0, ',', '.') }}
                                @if($remainingCapacity < 0)
                                    <span class="text-red-600 text-xs">(Sobreendeudado)</span>
                                @elseif($remainingCapacity < 50000)
                                    <span class="text-yellow-600 text-xs">(Capacidad limitada)</span>
                                @else
                                    <span class="text-green-600 text-xs">(Buena capacidad)</span>
                                @endif
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500">Historial de Pagos</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                @if($clientStats['loan_count'] > 0)
                                    @php
                                        $paidLoans = $client->loans->where('status', 'paid')->count();
                                        $paymentRatio = $clientStats['loan_count'] > 0 ? ($paidLoans / $clientStats['loan_count']) * 100 : 0;
                                    @endphp
                                    {{ number_format($paymentRatio, 0) }}% completados
                                    @if($paymentRatio >= 80)
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            Excelente
                                        </span>
                                    @elseif($paymentRatio >= 60)
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            Bueno
                                        </span>
                                    @else
                                        <span class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Regular
                                        </span>
                                    @endif
                                @else
                                    <span class="text-gray-500">Sin historial</span>
                                @endif
                            </dd>
                        </div>
                    </dl>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
