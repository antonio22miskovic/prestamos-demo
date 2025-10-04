<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContractsController extends Controller
{
    /**
     * Display contracts for the client
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

        // Get contracts from approved/active loans (these would have contracts)
        $contracts = $client->loans()
            ->whereIn('status', ['approved', 'active', 'paid'])
            ->whereNotNull('approved_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.contracts.index', compact('client', 'contracts'));
    }

    /**
     * Show specific contract
     */
    public function show(Request $request, $contractId): View
    {
        $user = $request->user();
        $client = $user->client;

        // For now, we'll find by loan ID since we don't have a separate contracts table yet
        $loan = $client->loans()
            ->with('loanApplication')
            ->findOrFail($contractId);

        return view('client.contracts.show', compact('client', 'loan'));
    }

    /**
     * Download contract PDF
     */
    public function download(Request $request, $contractId)
    {
        $user = $request->user();
        $client = $user->client;

        $loan = $client->loans()->findOrFail($contractId);

        // TODO: Implement PDF generation and download
        return response()->json(['message' => 'Funcionalidad de descarga de contrato en desarrollo']);
    }
}