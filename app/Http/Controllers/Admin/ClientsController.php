<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\User;
use App\Models\Loan;
use App\Models\LoanApplication;
use Illuminate\Http\Request;

class ClientsController extends Controller
{
    /**
     * Display a listing of clients with their loan information.
     */
    public function index(Request $request)
    {
        $query = Client::with(['user', 'loans' => function ($q) {
            $q->select('id', 'client_id', 'amount', 'status', 'approved_at', 'term_months', 'monthly_fee', 'total_amount')
              ->whereIn('status', ['approved', 'active', 'paid']);
        }])
        ->select([
            'id', 'user_id', 'document_type', 'document_number', 
            'income', 'expenses', 'employment', 'created_at'
        ]);

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereHas('loans', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'paid') {
                $query->whereHas('loans', function ($q) {
                    $q->where('status', 'paid');
                })->whereDoesntHave('loans', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'no_loans') {
                $query->whereDoesntHave('loans', function ($q) {
                    $q->whereIn('status', ['approved', 'active', 'paid']);
                });
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('document_number', 'like', "%{$search}%")
                  ->orWhereHas('user', function ($userQuery) use ($search) {
                      $userQuery->where('name', 'like', "%{$search}%")
                               ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('income_min')) {
            $query->where('income', '>=', $request->income_min);
        }

        if ($request->filled('income_max')) {
            $query->where('income', '<=', $request->income_max);
        }

        $query->orderBy('created_at', 'desc');

        $clients = $query->paginate(15)->withQueryString();

        // Estadísticas
        $stats = [
            'total_clients' => Client::count(),
            'active_loans' => Client::whereHas('loans', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'paid_loans' => Client::whereHas('loans', function ($q) {
                $q->where('status', 'paid');
            })->whereDoesntHave('loans', function ($q) {
                $q->where('status', 'active');
            })->count(),
            'no_loans' => Client::whereDoesntHave('loans', function ($q) {
                $q->whereIn('status', ['approved', 'active', 'paid']);
            })->count(),
        ];

        return view('admin.clients.index', compact('clients', 'stats'));
    }

    /**
     * Get clients data for AJAX requests
     */
    public function getClientsData(Request $request)
    {
        $query = Client::with(['user', 'loans' => function ($q) {
            $q->select('id', 'client_id', 'amount', 'status', 'approved_at', 'term_months', 'monthly_fee', 'total_amount')
              ->whereIn('status', ['approved', 'active', 'paid']);
        }])
        ->select([
            'id', 'user_id', 'document_type', 'document_number', 
            'income', 'expenses', 'employment', 'created_at'
        ]);

        // Filtros
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->whereHas('loans', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'paid') {
                $query->whereHas('loans', function ($q) {
                    $q->where('status', 'paid');
                })->whereDoesntHave('loans', function ($q) {
                    $q->where('status', 'active');
                });
            } elseif ($request->status === 'no_loans') {
                $query->whereDoesntHave('loans');
            }
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->whereHas('user', function ($userQuery) use ($search) {
                    $userQuery->where('name', 'like', "%{$search}%")
                             ->orWhere('email', 'like', "%{$search}%");
                })
                ->orWhere('document_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('income_min')) {
            $query->where('income', '>=', $request->income_min);
        }

        if ($request->filled('income_max')) {
            $query->where('income', '<=', $request->income_max);
        }

        $clients = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calcular estadísticas
        $totalClients = Client::count();
        $activeLoans = Client::whereHas('loans', function ($q) {
            $q->where('status', 'active');
        })->count();
        $paidLoans = Client::whereHas('loans', function ($q) {
            $q->where('status', 'paid');
        })->whereDoesntHave('loans', function ($q) {
            $q->where('status', 'active');
        })->count();
        $noLoans = Client::whereDoesntHave('loans')->count();

        $stats = [
            'total_clients' => $totalClients,
            'active_loans' => $activeLoans,
            'paid_loans' => $paidLoans,
            'no_loans' => $noLoans,
        ];

        return response()->json([
            'html' => view('admin.clients.partials.table', compact('clients'))->render(),
            'pagination' => $clients->appends($request->all())->links()->render(),
            'stats' => $stats
        ]);
    }

    /**
     * Display the specified client.
     */
    public function show(Client $client)
    {
        $client->load([
            'user',
            'loans' => function ($query) {
                $query->orderBy('created_at', 'desc');
            },
            'loanApplications' => function ($query) {
                $query->orderBy('created_at', 'desc')->limit(10);
            }
        ]);

        // Calcular estadísticas del cliente
        $clientStats = [
            'total_borrowed' => $client->loans->where('status', '!=', 'rejected')->sum('amount'),
            'total_paid' => $client->loans->where('status', 'paid')->sum('amount'),
            'current_debt' => $client->loans->where('status', 'active')->sum(function ($loan) {
                return $loan->remaining_balance;
            }),
            'monthly_payments' => $client->loans->where('status', 'active')->sum('monthly_fee'),
            'loan_count' => $client->loans->count(),
            'application_count' => $client->loanApplications->count(),
        ];

        return view('admin.clients.show', compact('client', 'clientStats'));
    }
}
