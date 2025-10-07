<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Loan;
use App\Models\Contract;
use App\Services\ContractService;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Http\Response;

class ContractsController extends Controller
{
    protected $contractService;

    public function __construct(ContractService $contractService)
    {
        $this->contractService = $contractService;
    }

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

        // Get loans with contracts
        $loans = $client->loans()
            ->whereIn('status', ['approved', 'active', 'paid'])
            ->whereNotNull('approved_at')
            ->with('contract')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('client.contracts.index', compact('client', 'loans'));
    }

    /**
     * Show specific contract
     */
    public function show(Request $request, $contractId): View
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

        $loan = $client->loans()
            ->with(['loanApplication', 'contract', 'amortizationSchedule' => function($query) {
                $query->orderBy('period_number');
            }])
            ->findOrFail($contractId);

        // If no contract exists, generate one
        if (!$loan->contract) {
            $contract = $this->contractService->generateContract($loan);
            $loan->load('contract');
        }

        return view('client.contracts.show', compact('client', 'loan'));
    }

    /**
     * Generate contract for a loan
     */
    public function generate(Request $request, $loanId)
    {
        $user = $request->user();
        
        // Log para debugging
        \Log::info('Contract generation attempt', [
            'user_id' => $user ? $user->id : 'null',
            'user_role' => $user ? $user->role : 'null',
            'loan_id' => $loanId,
            'authenticated' => auth()->check()
        ]);
        
        // Verificar que el usuario existe y tiene el rol correcto
        if (!$user) {
            \Log::error('No user found in contract generation');
            return redirect()->route('login')->with('error', 'Debes iniciar sesión para acceder a esta función.');
        }
        
        if ($user->role !== 'client') {
            \Log::error('User does not have client role', ['user_role' => $user->role]);
            return redirect()->route('dashboard')->with('error', 'No tienes permisos para acceder a esta función.');
        }
        
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

        $loan = $client->loans()
            ->whereIn('status', ['approved', 'active', 'paid'])
            ->whereNotNull('approved_at')
            ->findOrFail($loanId);

        // Check if contract already exists
        if ($this->contractService->hasContract($loan)) {
            return redirect()->route('client.contracts.show', $loan->id)
                ->with('info', 'El contrato ya existe para este préstamo.');
        }

        try {
            $contract = $this->contractService->generateContract($loan);
            
            return redirect()->route('client.contracts.show', $loan->id)
                ->with('success', 'Contrato generado exitosamente. Puedes verlo y descargarlo a continuación.')
                ->with('show_success_alert', true)
                ->with('contract_generated', true);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al generar el contrato: ' . $e->getMessage())
                ->with('show_error_alert', true);
        }
    }

    /**
     * Download contract PDF
     */
    public function download(Request $request, $contractId)
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

        $loan = $client->loans()->findOrFail($contractId);
        
        // Get or generate contract
        $contract = $loan->contract;
        if (!$contract) {
            $contract = $this->contractService->generateContract($loan);
        }

        try {
            return $this->contractService->downloadContract($contract);
        } catch (\Exception $e) {
            return redirect()->back()
                ->with('error', 'Error al descargar el contrato: ' . $e->getMessage());
        }
    }
}