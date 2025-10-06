<table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
    <thead class="bg-gray-50 dark:bg-gray-700">
        <tr>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Cliente</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Ingresos</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Créditos</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Estado</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Registro</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-300 uppercase tracking-wider">Acciones</th>
        </tr>
    </thead>
    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
        @forelse($clients as $client)
            <tr class="hover:bg-gray-50 dark:hover:bg-gray-700">
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">{{ $client->user->name }}</div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">{{ $client->user->email }}</div>
                    @if($client->document_number)
                        <div class="text-xs text-gray-400 dark:text-gray-500">
                            {{ $client->document_type }}: {{ $client->document_number }}
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    <div class="text-sm font-medium text-gray-900 dark:text-white">
                        ${{ number_format($client->income, 0, ',', '.') }}
                    </div>
                    <div class="text-sm text-gray-500 dark:text-gray-400">
                        Gastos: ${{ number_format($client->expenses, 0, ',', '.') }}
                    </div>
                    <div class="text-xs text-gray-400 dark:text-gray-500">
                        Disponible: ${{ number_format($client->income - $client->expenses, 0, ',', '.') }}
                    </div>
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @if($client->loans->count() > 0)
                        <div class="text-sm font-medium text-gray-900 dark:text-white">
                            {{ $client->loans->count() }} crédito(s)
                        </div>
                        @php
                            $activeLoans = $client->loans->where('status', 'active');
                            $totalDebt = $activeLoans->sum(function($loan) { return $loan->remaining_balance; });
                            $monthlyPayments = $activeLoans->sum('monthly_fee');
                        @endphp
                        @if($activeLoans->count() > 0)
                            <div class="text-sm text-gray-500 dark:text-gray-400">
                                Deuda: ${{ number_format($totalDebt, 0, ',', '.') }}
                            </div>
                            <div class="text-xs text-gray-400 dark:text-gray-500">
                                Cuota: ${{ number_format($monthlyPayments, 0, ',', '.') }}/mes
                            </div>
                        @else
                            <div class="text-sm text-green-600 dark:text-green-400">
                                Créditos pagados
                            </div>
                        @endif
                    @else
                        <div class="text-sm text-gray-500 dark:text-gray-400">
                            Sin créditos
                        </div>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap">
                    @php
                        $activeLoans = $client->loans->where('status', 'active');
                        $paidLoans = $client->loans->where('status', 'paid');
                    @endphp
                    @if($activeLoans->count() > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                            Activo
                        </span>
                    @elseif($paidLoans->count() > 0)
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                            Pagado
                        </span>
                    @else
                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                            Sin créditos
                        </span>
                    @endif
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900 dark:text-white">
                    {{ $client->created_at->format('d/m/Y') }}
                </td>
                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                    <a href="{{ route('admin.clients.show', $client) }}" 
                       class="inline-flex items-center justify-center px-4 py-2 border border-gray-300 dark:border-gray-600 text-sm font-medium rounded-md text-gray-700 dark:text-gray-300 bg-white dark:bg-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-colors">
                        Ver Detalles
                    </a>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-6 py-12 text-center">
                    <div class="text-gray-500 dark:text-gray-400">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                        </svg>
                        <h3 class="mt-2 text-sm font-medium text-gray-900 dark:text-white">No hay clientes</h3>
                        <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">No se encontraron clientes con los filtros aplicados.</p>
                    </div>
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
