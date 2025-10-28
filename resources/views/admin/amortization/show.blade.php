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

<!-- Payment Modal is now handled by SweetAlert2 -->

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
<script defer>
(async function() {
    // Wait for DOM and SweetAlert2 to be ready
    await new Promise(resolve => {
        if (document.readyState === 'loading') {
            document.addEventListener('DOMContentLoaded', resolve);
        } else {
            resolve();
        }
    });
    
    // Wait a bit for SweetAlert2 to load
    await new Promise(resolve => setTimeout(resolve, 100));
    
    // Now define functions
    window.openPaymentModal = async function(paymentId, maxAmount, currentPaid, paymentDate, notes) {
    const { value: formValues } = await Swal.fire({
        title: 'Editar Pago',
        html: `
            <div class="space-y-4" style="text-align: left;">
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Monto Pagado</label>
                    <input id="swal-amount_paid" 
                           type="number" 
                           step="0.01" 
                           min="0"
                           max="${maxAmount}"
                           value="${currentPaid}"
                           class="swal2-input bg-gray-700 text-white border-gray-600">
                    <div class="text-xs text-gray-400 mt-1">Monto máximo: $${parseFloat(maxAmount).toLocaleString('es-MX', {minimumFractionDigits: 2})}</div>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Fecha de Pago</label>
                    <input id="swal-payment_date" 
                           type="date" 
                           value="${paymentDate}"
                           class="swal2-input bg-gray-700 text-white border-gray-600">
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-300 mb-2">Notas</label>
                    <textarea id="swal-notes" 
                              rows="3"
                              class="swal2-input bg-gray-700 text-white border-gray-600">${notes}</textarea>
                </div>
                </div>
        `,
        icon: 'info',
        showCancelButton: true,
        confirmButtonText: 'Guardar Cambios',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#2563eb',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        focusConfirm: false,
        preConfirm: () => {
            return {
                amount_paid: document.getElementById('swal-amount_paid').value,
                payment_date: document.getElementById('swal-payment_date').value,
                notes: document.getElementById('swal-notes').value
            };
        },
        customClass: {
            popup: 'bg-gray-800 text-white',
            title: 'text-white',
            htmlContainer: 'text-gray-300',
            confirmButton: 'px-6 py-2 rounded-md bg-blue-600 hover:bg-blue-700 text-white',
            cancelButton: 'px-6 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white',
            input: 'bg-gray-700 text-white border-gray-600',
            textarea: 'bg-gray-700 text-white border-gray-600'
        }
    });

    if (formValues) {
        // Mostrar loading
        Swal.fire({
            title: 'Guardando...',
            text: 'Por favor espera',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'bg-gray-800 text-white',
                title: 'text-white',
                htmlContainer: 'text-gray-300'
            }
        });

        // Validación
        if (parseFloat(formValues.amount_paid) > parseFloat(maxAmount)) {
            Swal.fire({
                title: 'Error',
                text: 'El monto pagado no puede ser mayor al monto de la cuota.',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'bg-gray-800 text-white',
                    title: 'text-white',
                    htmlContainer: 'text-gray-300'
                }
            });
            return;
        }

        try {
            const formData = new FormData();
            formData.append('amount_paid', formValues.amount_paid);
            formData.append('payment_date', formValues.payment_date);
            formData.append('notes', formValues.notes);
            formData.append('_token', document.querySelector('input[name="_token"]').value);
            formData.append('_method', 'PATCH');

            const response = await fetch(`{{ url('/admin/amortization') }}/${paymentId}/payment`, {
            method: 'PATCH',
            body: formData,
            headers: {
                    'Accept': 'application/json'
            }
        });
        
        const result = await response.json();
        
            if (response.ok && result.success) {
                Swal.fire({
                    title: '¡Éxito!',
                    text: 'Pago actualizado correctamente',
                    icon: 'success',
                    confirmButtonColor: '#10b981',
                    customClass: {
                        popup: 'bg-gray-800 text-white',
                        title: 'text-white',
                        htmlContainer: 'text-gray-300'
                    }
                }).then(() => {
            location.reload();
                });
        } else {
                throw new Error(result.message || 'Error al actualizar el pago');
        }
    } catch (error) {
        console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: error.message || 'Error al actualizar el pago',
                icon: 'error',
                confirmButtonColor: '#ef4444',
                customClass: {
                    popup: 'bg-gray-800 text-white',
                    title: 'text-white',
                    htmlContainer: 'text-gray-300'
                }
            });
        }
    }
    };
    
    window.regenerateSchedule = async function() {
    const confirmed = await Swal.fire({
        title: '¿Regenerar Tabla de Amortización?',
        html: `
            <div class="space-y-4">
                <p class="text-gray-300 mb-4">Esta acción eliminará todos los registros de pagos existentes y creará una nueva tabla de amortización basada en los parámetros del préstamo.</p>
                <div class="bg-red-900/30 border border-red-700 rounded-lg p-4">
                    <div class="flex items-start">
                        <svg class="w-6 h-6 text-red-400 mr-3 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"></path>
                        </svg>
                        <div>
                            <p class="text-red-300 font-semibold">Advertencia</p>
                            <p class="text-red-200 text-sm">Todos los datos de pagos se perderán permanentemente.</p>
                        </div>
                    </div>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Sí, Regenerar',
        cancelButtonText: 'Cancelar',
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        reverseButtons: true,
        customClass: {
            popup: 'bg-gray-800 text-white',
            title: 'text-white',
            htmlContainer: 'text-gray-300',
            confirmButton: 'px-6 py-2 rounded-md bg-red-600 hover:bg-red-700 text-white',
            cancelButton: 'px-6 py-2 rounded-md bg-gray-600 hover:bg-gray-700 text-white'
        }
    });

    if (confirmed.isConfirmed) {
        // Mostrar loading
        Swal.fire({
            title: 'Regenerando...',
            text: 'Por favor espera',
            icon: 'info',
            allowOutsideClick: false,
            allowEscapeKey: false,
            didOpen: () => {
                Swal.showLoading();
            },
            customClass: {
                popup: 'bg-gray-800 text-white',
                title: 'text-white',
                htmlContainer: 'text-gray-300'
            }
        });

        // Crear y enviar formulario
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
    };
})();
</script>
@endpush
