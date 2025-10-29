@extends('layouts.client')

@section('title', 'Detalles del Crédito')

@php
// Function to convert number to words in Spanish
function numberToWords($number) {
    $ones = ['', 'uno', 'dos', 'tres', 'cuatro', 'cinco', 'seis', 'siete', 'ocho', 'nueve', 'diez',
             'once', 'doce', 'trece', 'catorce', 'quince', 'dieciséis', 'diecisiete', 'dieciocho', 'diecinueve', 'veinte',
             'veintiuno', 'veintidós', 'veintitrés', 'veinticuatro', 'veinticinco', 'veintiséis', 'veintisiete', 'veintiocho', 'veintinueve'];
    
    $tens = ['', '', 'veinte', 'treinta', 'cuarenta', 'cincuenta', 'sesenta', 'setenta', 'ochenta', 'noventa'];
    $hundreds = ['', 'cien', 'doscientos', 'trescientos', 'cuatrocientos', 'quinientos', 'seiscientos', 'setecientos', 'ochocientos', 'novecientos'];
    
    if ($number == 0) return 'cero';
    
    // Handle cents
    $wholePart = intval($number);
    $cents = round(($number - $wholePart) * 100);
    
    $result = '';
    
    if ($wholePart >= 1000) {
        $thousands = intval($wholePart / 1000);
        if ($thousands == 1) {
            $result .= 'mil ';
        } else {
            $result .= numberToWords($thousands) . ' mil ';
        }
        $wholePart = $wholePart % 1000;
    }
    
    if ($wholePart >= 100) {
        $hundred = intval($wholePart / 100);
        if ($hundred == 1) {
            $result .= 'cien ';
        } else {
            $result .= $hundreds[$hundred] . ' ';
        }
        $wholePart = $wholePart % 100;
    }
    
    if ($wholePart > 0) {
        if ($wholePart <= 29) {
            $result .= $ones[$wholePart] . ' ';
        } else {
            $ten = intval($wholePart / 10);
            $one = $wholePart % 10;
            $result .= $tens[$ten];
            if ($one > 0) {
                $result .= ' y ' . $ones[$one];
            }
            $result .= ' ';
        }
    }
    
    $result .= 'dólares';
    
    if ($cents > 0) {
        $result .= ' con ' . numberToWords($cents) . ' centavos';
    }
    
    return trim($result);
}
@endphp

@section('content')
    <div class="space-y-6">
        <!-- Back Button -->
        <div>
            <a href="{{ route('client.loans.index') }}" 
               class="inline-flex items-center text-sm text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
                Volver a Mis Créditos
            </a>
        </div>

        <!-- Loan Header -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-600 to-blue-700">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-2xl font-bold text-white">
                            Préstamo #{{ str_pad($loan->id, 6, '0', STR_PAD_LEFT) }}
                        </h1>
                        <p class="text-blue-100 mt-1">{{ $loan->loanApplication->purpose ?? 'Sin especificar' }}</p>
                    </div>
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium {{ $loan->status === 'active' ? 'bg-green-100 text-green-800' : 'bg-blue-100 text-blue-800' }}">
                        {{ $loan->status === 'active' ? 'Activo' : 'Aprobado' }}
                    </span>
                </div>
            </div>
            
            <div class="px-6 py-6">
                <!-- Loan Details Grid -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Original</dt>
                        <dd class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($loan->amount, 2, ',', '.') }}
                        </dd>
                        <p class="mt-1 text-xs font-semibold text-black dark:text-gray-300">{{ numberToWords($loan->amount) }}</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Saldo Pendiente</dt>
                        <dd class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($loan->remaining_balance, 2, ',', '.') }}
                        </dd>
                        <p class="mt-1 text-xs font-semibold text-black dark:text-gray-300">{{ numberToWords($loan->remaining_balance) }}</p>
                    </div>
                    
                    <div class="bg-gray-50 dark:bg-gray-700/50 rounded-lg p-4">
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual</dt>
                        <dd class="mt-2 text-2xl font-bold text-gray-900 dark:text-white">
                            ${{ number_format($loan->monthly_fee, 2, ',', '.') }}
                        </dd>
                        <p class="mt-1 text-xs font-semibold text-black dark:text-gray-300">{{ numberToWords($loan->monthly_fee) }}</p>
                    </div>
                </div>

                <!-- Additional Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ number_format($loan->interest_rate, 2) }}%</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $loan->term_months }} meses</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto Total</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-white">${{ number_format($loan->total_amount, 2, ',', '.') }}</dd>
                    </div>
                    
                    <div>
                        <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Fecha de Aprobación</dt>
                        <dd class="mt-1 text-lg text-gray-900 dark:text-white">{{ $loan->approved_at->format('d/m/Y') }}</dd>
                    </div>
                </div>

                <!-- Progress Bar -->
                @php
                    $totalPaid = $loan->amount - $loan->remaining_balance;
                    $progressPercentage = $loan->amount > 0 ? ($totalPaid / $loan->amount) * 100 : 0;
                @endphp
                <div class="mt-6">
                    <div class="flex items-center justify-between text-sm mb-2">
                        <span class="font-medium text-gray-700 dark:text-gray-300">Progreso del Préstamo</span>
                        <span class="text-gray-500 dark:text-gray-400">{{ number_format($progressPercentage, 1) }}%</span>
                    </div>
                    <div class="w-full bg-gray-200 rounded-full h-3">
                        <div class="bg-gradient-to-r from-blue-500 to-blue-600 h-3 rounded-full transition-all duration-300" style="width: {{ $progressPercentage }}%"></div>
                    </div>
                    <div class="mt-2 flex justify-between text-sm text-gray-500 dark:text-gray-400">
                        <span>Pagado: ${{ number_format($totalPaid, 2, ',', '.') }}</span>
                        <span>Pendiente: ${{ number_format($loan->remaining_balance, 2, ',', '.') }}</span>
                    </div>
                </div>

                <!-- Next Payment Section -->
                @php
                    if ($loan->amortizationSchedule && $loan->amortizationSchedule->count() > 0) {
                        $items = $loan->amortizationSchedule;
                    } else {
                        $items = $loan->installments;
                    }
                    $nextInstallment = $items->where('status', 'pending')->first();
                @endphp
                @if($nextInstallment)
                <div class="mt-6 bg-gradient-to-r from-blue-50 to-blue-100 dark:from-blue-900/20 dark:to-blue-800/20 border border-blue-200 dark:border-blue-700 rounded-lg p-6">
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-lg font-semibold text-gray-900 dark:text-white">Próximo Pago</h3>
                            <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">Cuota #{{ isset($nextInstallment->period_number) ? $nextInstallment->period_number : $nextInstallment->number }} - Vence {{ $nextInstallment->due_date->format('d/m/Y') }}</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100 mt-2">
                                ${{ number_format(isset($nextInstallment->payment_amount) ? $nextInstallment->payment_amount : $nextInstallment->total, 2, ',', '.') }}
                            </p>
                            <p class="text-xs text-black dark:text-gray-300 mt-1 font-semibold">{{ numberToWords(isset($nextInstallment->payment_amount) ? $nextInstallment->payment_amount : $nextInstallment->total) }}</p>
                        </div>
                        <button onclick="openPaymentModal({{ $nextInstallment->id }}, {{ isset($nextInstallment->payment_amount) ? $nextInstallment->payment_amount : $nextInstallment->total }})" 
                                class="inline-flex items-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-green-600 to-green-700 hover:from-green-700 hover:to-green-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 transition-colors shadow-lg">
                            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                            </svg>
                            Realizar Pago
                        </button>
                    </div>
                </div>
                @endif
            </div>
        </div>

        <!-- Installments Table -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
                <div class="flex items-center justify-between">
                    <h2 class="text-lg font-semibold text-gray-900 dark:text-white">Cronograma de Pagos</h2>
                    @if(($loan->amortizationSchedule && $loan->amortizationSchedule->count() > 0) || ($loan->installments && $loan->installments->count() > 0))
                    <a href="{{ route('client.loans.download-statement', $loan->id) }}" 
                       class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-gradient-to-r from-purple-600 to-purple-700 hover:from-purple-700 hover:to-purple-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 transition-colors">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar Estado de Cuenta
                    </a>
                    @endif
                </div>
            </div>
            @if(($loan->amortizationSchedule && $loan->amortizationSchedule->count() > 0) || ($loan->installments && $loan->installments->count() > 0))
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-900">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider"># Cuota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Fecha Vencimiento</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Monto Cuota</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Capital</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Interés</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">Estado</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @php
                            $items = $loan->amortizationSchedule && $loan->amortizationSchedule->count() > 0 
                                ? $loan->amortizationSchedule 
                                : $loan->installments;
                        @endphp
                        @foreach($items as $item)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ isset($item->period_number) ? $item->period_number : $item->number }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">{{ $item->due_date->format('d/m/Y') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${{ number_format(isset($item->payment_amount) ? $item->payment_amount : $item->total, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${{ number_format(isset($item->principal_payment) ? $item->principal_payment : $item->principal, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">${{ number_format(isset($item->interest_payment) ? $item->interest_payment : $item->interest, 2, ',', '.') }}</td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium {{ $item->status === 'paid' ? 'bg-green-100 text-green-800' : ($item->status === 'partial' ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                    {{ $item->status === 'paid' ? 'Pagado' : ($item->status === 'partial' ? 'Parcial' : 'Pendiente') }}
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <div class="px-6 py-12 text-center">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <h3 class="mt-4 text-lg font-medium text-gray-900 dark:text-white">No hay tabla de amortización disponible</h3>
                <p class="mt-2 text-sm text-gray-500 dark:text-gray-400">
                    La tabla de amortización será generada una vez que el préstamo sea aprobado.
                </p>
            </div>
            @endif
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-3">
            <a href="{{ route('client.loans.index') }}"
               class="inline-flex items-center justify-center px-6 py-3 border border-gray-300 dark:border-gray-600 text-base font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                Volver
            </a>
            
            @if($loan->contract_signed_at)
                <a href="{{ route('client.contracts.show', $loan->id) }}" 
                   class="inline-flex items-center justify-center px-6 py-3 border border-transparent text-base font-medium rounded-md text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    Ver Contrato
                </a>
            @endif
        </div>
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function openPaymentModal(installmentId, amount) {
            Swal.fire({
                title: 'Realizar Pago',
                html: `
                    <div class="space-y-4 text-left">
                        <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700 rounded-lg p-4">
                            <p class="text-sm text-blue-800 dark:text-blue-200 font-medium">Monto a Pagar</p>
                            <p class="text-2xl font-bold text-blue-900 dark:text-blue-100">$${amount.toFixed(2).replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</p>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Monto a Pagar
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="text" id="payment_amount" class="w-full pl-8 pr-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white" value="${amount.toFixed(2)}">
                            </div>
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Fecha de Pago
                            </label>
                            <input type="date" id="payment_date" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white" value="${new Date().toISOString().split('T')[0]}">
                        </div>
                        
                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                                Observaciones (Opcional)
                            </label>
                            <textarea id="payment_notes" rows="3" class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md dark:bg-gray-700 dark:text-white" placeholder="Notas adicionales sobre el pago"></textarea>
                        </div>
                        
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700 rounded-lg p-3">
                            <p class="text-xs text-yellow-800 dark:text-yellow-200">
                                <svg class="w-4 h-4 inline mr-1" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-ple="evenodd"/>
                                </svg>
                                Si pagas un monto mayor al de la cuota, el excedente se aplicará automáticamente a las cuotas futuras.
                            </p>
                        </div>
                    </div>
                `,
                customClass: {
                    popup: 'dark:bg-gray-800',
                    title: 'dark:text-white',
                    htmlContainer: 'dark:text-gray-300'
                },
                confirmButtonText: 'Confirmar Pago',
                cancelButtonText: 'Cancelar',
                showCancelButton: true,
                preConfirm: () => {
                    const amount = document.getElementById('payment_amount').value.replace(/,/g, '');
                    const date = document.getElementById('payment_date').value;
                    
                    if (!amount || parseFloat(amount) <= 0) {
                        Swal.showValidationMessage('El monto pagado debe ser mayor a $0.00');
                        return false;
                    }
                    
                    return {
                        amount: parseFloat(amount),
                        date: date,
                        notes: document.getElementById('payment_notes').value
                    };
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Procesando pago...',
                        allowOutsideClick: false,
                        customClass: {
                            popup: 'dark:bg-gray-800',
                            title: 'dark:text-white',
                            htmlContainer: 'dark:text-gray-300'
                        },
                        didOpen: () => {
                            Swal.showLoading();
                        }
                    });
                    
                    // Submit payment
                    fetch(`{{ route('client.loans.process-payment', $loan->id) }}`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                        },
                        body: JSON.stringify({
                            installment_id: installmentId,
                            amount: result.value.amount,
                            date: result.value.date,
                            notes: result.value.notes
                        })
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Pago Realizado',
                                text: data.message || 'Tu pago ha sido registrado exitosamente.',
                                confirmButtonText: 'Aceptar',
                                customClass: {
                                    popup: 'dark:bg-gray-800',
                                    title: 'dark:text-white',
                                    htmlContainer: 'dark:text-gray-300',
                                    confirmButton: 'bg-green-600 hover:bg-green-700 text-white'
                                }
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: data.message || 'Hubo un error al procesar tu pago. Por favor intenta nuevamente.',
                                confirmButtonText: 'Cerrar',
                                customClass: {
                                    popup: 'dark:bg-gray-800',
                                    title: 'dark:text-white',
                                    htmlContainer: 'dark:text-gray-300',
                                    confirmButton: 'bg-red-600 hover:bg-red-700 text-white'
                                }
                            });
                        }
                    })
                    .catch(error => {
                        console.error('Payment error:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al procesar tu pago. Por favor intenta nuevamente.',
                            confirmButtonText: 'Cerrar',
                            customClass: {
                                popup: 'dark:bg-gray-800',
                                title: 'dark:text-white',
                                htmlContainer: 'dark:text-gray-300',
                                confirmButton: 'bg-red-600 hover:bg-red-700 text-white'
                            }
                        });
                    });
                }
            });
        }
    </script>
    @endpush
@endsection

