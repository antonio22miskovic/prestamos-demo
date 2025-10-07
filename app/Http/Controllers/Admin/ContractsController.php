<?php

namespace App\Http\Controllers\Admin;

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
     * Display contracts for admin
     */
    public function index(Request $request): View
    {
        // Get all loans with contracts for admin view
        $loans = Loan::with(['client.user', 'contract', 'loanApplication'])
            ->whereIn('status', ['approved', 'active', 'paid'])
            ->whereNotNull('approved_at')
            ->orderBy('created_at', 'desc')
            ->get();

        return view('admin.contracts.index', compact('loans'));
    }

    /**
     * Show specific contract
     */
    public function show(Request $request, $loanId): View
    {
        $loan = Loan::with(['client.user', 'contract', 'loanApplication', 'amortizationSchedule' => function($query) {
            $query->orderBy('period_number');
        }])->findOrFail($loanId);

        // If no contract exists, generate one
        if (!$loan->contract) {
            $contract = $this->contractService->generateContract($loan);
            $loan->load('contract');
        }

        return view('admin.contracts.show', compact('loan'));
    }

    /**
     * Generate contract for a loan
     */
    public function generate(Request $request, $loanId)
    {
        $loan = Loan::with(['client.user', 'loanApplication'])
            ->whereIn('status', ['approved', 'active', 'paid'])
            ->whereNotNull('approved_at')
            ->findOrFail($loanId);

        // Check if contract already exists
        if ($this->contractService->hasContract($loan)) {
            return redirect()->route('admin.applications.show', $loan->loanApplication->id)
                ->with('info', 'El contrato ya existe para este préstamo.');
        }

        try {
            $contract = $this->contractService->generateContract($loan);
            
            return redirect()->route('admin.applications.show', $loan->loanApplication->id)
                ->with('success', 'Contrato generado exitosamente. Puedes verlo y descargarlo en la sección de contratos.')
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
    public function download(Request $request, $loanId)
    {
        $loan = Loan::findOrFail($loanId);
        
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
