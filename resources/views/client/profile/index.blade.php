@extends('layouts.client')

@section('title', 'Mi Perfil')

@section('content')
    <div class="space-y-6">
        <!-- Personal Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                        Información Personal
                    </h3>
                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                        Solo Lectura
                    </span>
                </div>
            </div>
            
            <div class="px-6 py-4">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Nombre Completo</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $client->user->name }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Correo Electrónico</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $client->user->email }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Teléfono</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $client->user->phone ?? 'No registrado' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Registro</dt>
                        <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                            {{ $client->user->created_at->format('d/m/Y') }}
                        </dd>
                    </div>
                </div>
            </div>
        </div>

        <!-- Financial Information -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Información Financiera
                </h3>
            </div>
            
            <div class="px-6 py-4">
                @if($client->employment)
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tipo de Empleo</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $client->employment }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Empresa</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $client->company_name ?? 'No especificado' }}
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Años de Experiencia</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
                                {{ $client->employment_years ?? 'No especificado' }} años
                            </dd>
                        </div>
                        <div>
                            <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Ingresos Mensuales</dt>
                            <dd class="mt-1 text-sm text-gray-900 dark:text-white">
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
                            <dd class="mt-1 text-sm font-semibold text-green-600 dark:text-green-400">
                                ${{ number_format($client->income - $client->expenses, 0, ',', '.') }}
                            </dd>
                        </div>
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">Información financiera no completada</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Completa una solicitud de préstamo para registrar tu información financiera.
                        </p>
                        <div class="mt-4">
                            <a href="{{ route('client.loan-application.step1') }}" 
                               class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                                Completar Información
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <!-- Documents -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">
                    Documentos Cargados
                </h3>
            </div>
            
            <div class="px-6 py-4">
                @if($documents->count() > 0)
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @php
                            $documentLabels = [
                                'identity' => ['label' => 'Documento de Identidad', 'icon' => 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
                                'bank_statement' => ['label' => 'Estado de Cuenta', 'icon' => 'M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z'],
                                'employment_proof' => ['label' => 'Comprobante Laboral', 'icon' => 'M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2-2v2m8 0H8m8 0v2a2 2 0 01-2 2H10a2 2 0 01-2-2V6']
                            ];
                        @endphp
                        
                        @foreach(['identity', 'bank_statement', 'employment_proof'] as $docType)
                            @php $doc = $documents->get($docType); @endphp
                            <div class="border border-gray-200 dark:border-gray-700 rounded-lg p-4">
                                <div class="flex items-center mb-3">
                                    <div class="flex-shrink-0">
                                        <div class="w-8 h-8 {{ $doc ? 'bg-green-100 dark:bg-green-900' : 'bg-gray-100 dark:bg-gray-700' }} rounded-md flex items-center justify-center">
                                            <svg class="w-5 h-5 {{ $doc ? 'text-green-600 dark:text-green-400' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $documentLabels[$docType]['icon'] }}"/>
                                            </svg>
                                        </div>
                                    </div>
                                    <div class="ml-3">
                                        <h4 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $documentLabels[$docType]['label'] }}
                                        </h4>
                                        @if($doc)
                                            <p class="text-xs text-gray-500 dark:text-gray-400">
                                                Cargado el {{ $doc->uploaded_at->format('d/m/Y') }}
                                            </p>
                                        @endif
                                    </div>
                                </div>
                                
                                @if($doc)
                                    <div class="flex items-center justify-between">
                                        <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium {{ $doc->status === 'approved' ? 'bg-green-100 text-green-800' : ($doc->status === 'rejected' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                                            @if($doc->status === 'approved')
                                                Aprobado
                                            @elseif($doc->status === 'rejected')
                                                Rechazado
                                            @else
                                                Pendiente
                                            @endif
                                        </span>
                                        <span class="text-xs text-gray-500 dark:text-gray-400">
                                            {{ number_format($doc->file_size / 1024, 0) }} KB
                                        </span>
                                    </div>
                                    
                                    @if($doc->status === 'rejected' && $doc->rejection_reason)
                                        <div class="mt-2 p-2 bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-800 rounded text-xs text-red-700 dark:text-red-300">
                                            {{ $doc->rejection_reason }}
                                        </div>
                                    @endif
                                @else
                                    <div class="text-center">
                                        <span class="text-xs text-gray-500 dark:text-gray-400">No cargado</span>
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-6">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        <h3 class="mt-4 text-sm font-medium text-gray-900 dark:text-white">No tienes documentos cargados</h3>
                        <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                            Los documentos se cargan durante el proceso de solicitud de préstamo.
                        </p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Future Feature Notice -->
        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-800 rounded-lg p-6">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-6 h-6 text-yellow-600 dark:text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800 dark:text-yellow-200">
                        Funcionalidad en Desarrollo
                    </h3>
                    <div class="mt-2 text-sm text-yellow-700 dark:text-yellow-300">
                        <p>La edición de perfil estará disponible en una próxima actualización. Por ahora, tu información es de solo lectura.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
