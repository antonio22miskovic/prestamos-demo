<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LoansController extends Controller
{
    /**
     * Display active loans for the client
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $client = $user->client;

        if (!$client) {
            $client = Client::create([
                'user_id' => $user->id,
                'employment' => null,
                'income' => 0,
                'expenses' => 0,
                'employment_years' => null,
                'company_name' => null,
            ]);
        }

        // Get active loans with installments
        $activeLoans = $client->loans()
            ->whereIn('status', ['active', 'approved'])
            ->with('installments')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.loans.index', compact('client', 'activeLoans'));
    }

    /**
     * Show specific loan details
     */
    public function show(Request $request, $loanId): View
    {
        $user = $request->user();
        $client = $user->client;

        $loan = $client->loans()
            ->with(['installments', 'loanApplication'])
            ->findOrFail($loanId);

        return view('client.loans.show', compact('client', 'loan'));
    }
}