@extends('layouts.admin')

@section('title', 'Tabla de Amortización - Préstamo #' . $loan->id)

@section('content')
<div class="container mx-auto px-4 py-6">
    <!-- Breadcrumb -->
    <nav class="flex mb-6" aria-label="Breadcrumb">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('admin.applications.index') }}" class="inline-flex items-center text-sm font-medium text-gray-700 hover:text-blue-600 dark:text-gray-400 dark:hover:text-white">
                    <svg class="w-3 h-3 mr-2.5" fill="currentColor" viewBox="0 0 20 20">
                        <path d="m19.707 9.293-2-2-7-7a1 1 0 0 0-1.414 0l-7 7-2 2a1 1 0 0 0 1.414 1.414L2 10.414V18a2 2 0 0 0 2 2h3a1 1 0 0 0 1-1v-4a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1v4a1 1 0 0 0 1 1h3a2 2 0 0 0 2-2v-7.586l.293.293a1 1 0 0 0 1.414-1.414Z"/>
                    </svg>
                    Solicitudes
                </a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-3 h-3 text-gray-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                    <span class="ml-1 text-sm font-medium text-gray-500 md:ml-2 dark:text-gray-400">Tabla de Amortización</span>
                </div>
            </li>
        </ol>
    </nav>

    <!-- Header -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg mb-6">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700 flex justify-between items-center">
            <div>
                <h1 class="text-2xl font-bold text-gray-900 dark:text-white">
                    Tabla de Amortización
                </h1>
                <p class="text-sm text-gray-600 dark:text-gray-400 mt-1">
                    Préstamo #{{ $loan->id }} - {{ $loan->client->user->name }}
                </p>
            </div>
            <div class="flex space-x-3">
                <a href="{{ route('admin.amortization.download-pdf', $loan) }}" 
                   class="inline-flex items-center px-4 py-2 bg-red-600 hover:bg-red-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Descargar PDF
                </a>
                <button onclick="regenerateSchedule()" 
                        class="inline-flex items-center px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md transition-colors">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                    </svg>
                    Regenerar Tabla
                </button>
            </div>
        </div>

        <!-- Loan Summary -->
        <div class="px-6 py-4 bg-gray-50 dark:bg-gray-700">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Monto del Préstamo</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($loan->amount, 2) }}</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Tasa de Interés</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $loan->interest_rate }}% anual</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Plazo</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">{{ $loan->term_months }} meses</dd>
                </div>
                <div>
                    <dt class="text-sm font-medium text-gray-500 dark:text-gray-400">Cuota Mensual</dt>
                    <dd class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">${{ number_format($loan->monthly_fee, 2) }}</dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Amortization Table -->
    <div class="bg-white dark:bg-gray-800 shadow rounded-lg overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-700">
            <h2 class="text-lg font-medium text-gray-900 dark:text-white">Cronograma de Pagos</h2>
        </div>
        
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            #
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Fecha Vencimiento
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Saldo Inicial
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Cuota
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Capital
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Interés
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Saldo Final
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Estado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Pagado
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">
                            Acciones
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($loan->amortizationSchedule as $payment)
                    <tr class="hover:bg-gray-50 dark:hover:bg-gray-700 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            {{ $payment->period_number }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            {{ $payment->due_date->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($payment->beginning_balance, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-white">
                            ${{ number_format($payment->payment_amount, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($payment->principal_payment, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($payment->interest_payment, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($payment->ending_balance, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @php
                                $statusClasses = [
                                    'pending' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900 dark:text-yellow-300',
                                    'paid' => 'bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300',
                                    'partial' => 'bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-300',
                                    'overdue' => 'bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300'
                                ];
                                $status = $payment->isOverdue() ? 'overdue' : $payment->status;
                            @endphp
                            <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full {{ $statusClasses[$status] }}">
                                @switch($status)
                                    @case('pending')
                                        Pendiente
                                        @break
                                    @case('paid')
                                        Pagado
                                        @break
                                    @case('partial')
                                        Parcial
                                        @break
                                    @case('overdue')
                                        Vencido
                                        @break
                                @endswitch
                            </span>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                            ${{ number_format($payment->amount_paid, 2) }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <button onclick="openPaymentModal({{ $payment->id }}, {{ $payment->payment_amount }}, {{ $payment->amount_paid }}, '{{ $payment->payment_date ? $payment->payment_date->format('Y-m-d') : '' }}', '{{ addslashes($payment->notes ?? '') }}')"
                                    class="text-blue-600 hover:text-blue-900 dark:text-blue-400 dark:hover:text-blue-300 transition-colors">
                                Editar
                            </button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot class="bg-gray-50 dark:bg-gray-700">
                    <tr>
                        <th colspan="3" class="px-6 py-3 text-right text-sm font-medium text-gray-900 dark:text-white">
                            Totales:
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                            ${{ number_format($loan->amortizationSchedule->sum('payment_amount'), 2) }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                            ${{ number_format($loan->amortizationSchedule->sum('principal_payment'), 2) }}
                        </th>
                        <th class="px-6 py-3 text-left text-sm font-medium text-gray-900 dark:text-white">
                            ${{ number_format($loan->amortizationSchedule->sum('interest_payment'), 2) }}
                        </th>
                        <th colspan="4" class="px-6 py-3"></th>
                    </tr>
                </tfoot>
            </table>
        </div>
    </div>
</div>

<!-- Payment Modal -->
<div id="paymentModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden" style="z-index: 50;">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white dark:bg-gray-800">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 dark:text-white mb-4">Editar Pago</h3>
            <form id="paymentForm">
                @csrf
                @method('PATCH')
                <div class="mb-4">
                    <label for="amount_paid" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Monto Pagado
                    </label>
                    <input type="number" 
                           id="amount_paid" 
                           name="amount_paid" 
                           step="0.01" 
                           min="0"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="payment_date" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Fecha de Pago
                    </label>
                    <input type="date" 
                           id="payment_date" 
                           name="payment_date"
                           class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white">
                </div>
                
                <div class="mb-4">
                    <label for="notes" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">
                        Notas
                    </label>
                    <textarea id="notes" 
                              name="notes" 
                              rows="3"
                              class="w-full px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:text-white"></textarea>
                </div>
                
                <div class="flex justify-end space-x-3 pt-4">
                    <button type="button" 
                            onclick="closePaymentModal()"
                            class="px-4 py-2 text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 border border-gray-300 dark:border-gray-600 rounded-md hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition-colors">
                        Guardar
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
let currentPaymentId = null;

function openPaymentModal(paymentId, maxAmount, currentPaid, paymentDate, notes) {
    currentPaymentId = paymentId;
    document.getElementById('amount_paid').value = currentPaid;
    document.getElementById('amount_paid').max = maxAmount;
    document.getElementById('payment_date').value = paymentDate;
    document.getElementById('notes').value = notes;
    document.getElementById('paymentModal').classList.remove('hidden');
}

function closePaymentModal() {
    document.getElementById('paymentModal').classList.add('hidden');
    currentPaymentId = null;
}

document.getElementById('paymentForm').addEventListener('submit', async function(e) {
    e.preventDefault();
    
    if (!currentPaymentId) return;
    
    const formData = new FormData(this);
    
    try {
        const response = await fetch(`/admin/amortization/${currentPaymentId}/payment`, {
            method: 'PATCH',
            body: formData,
            headers: {
                'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
            }
        });
        
        const result = await response.json();
        
        if (result.success) {
            location.reload();
        } else {
            alert('Error al actualizar el pago');
        }
    } catch (error) {
        console.error('Error:', error);
        alert('Error al actualizar el pago');
    }
});

function regenerateSchedule() {
    if (confirm('¿Está seguro de que desea regenerar la tabla de amortización? Esto eliminará todos los registros de pagos existentes.')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '{{ route("admin.amortization.regenerate", $loan) }}';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '{{ csrf_token() }}';
        form.appendChild(csrfToken);
        
        document.body.appendChild(form);
        form.submit();
    }
}

// Close modal when clicking outside
document.getElementById('paymentModal').addEventListener('click', function(e) {
    if (e.target === this) {
        closePaymentModal();
    }
});
</script>
@endpush
