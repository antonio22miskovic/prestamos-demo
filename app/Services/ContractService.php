<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\Contract;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContractService
{
    /**
     * Generate contract PDF for a loan
     */
    public function generateContract(Loan $loan): Contract
    {
        // Load necessary relationships
        $loan->load([
            'client.user',
            'loanApplication',
            'amortizationSchedule' => function($query) {
                $query->orderBy('period_number');
            }
        ]);

        // Generate PDF
        $pdf = Pdf::loadView('contracts.pdf', compact('loan'))
                  ->setPaper('a4', 'portrait')
                  ->setOptions([
                      'isHtml5ParserEnabled' => true,
                      'isRemoteEnabled' => true,
                      'defaultFont' => 'Arial'
                  ]);

        // Generate unique filename
        $filename = 'contrato-prestamo-' . $loan->id . '-' . now()->format('Y-m-d-H-i-s') . '.pdf';
        $path = 'contracts/' . $filename;

        // Store PDF in storage
        Storage::disk('public')->put($path, $pdf->output());

        // Create contract record
        $contract = Contract::create([
            'loan_id' => $loan->id,
            'contract_path' => $path,
            'signed_by_client' => false,
            'signed_at' => null,
            'signature_meta' => null,
            'signature_ip' => null,
            'terms_accepted' => null,
        ]);

        return $contract;
    }

    /**
     * Get contract download URL
     */
    public function getDownloadUrl(Contract $contract): string
    {
        return Storage::disk('public')->url($contract->contract_path);
    }

    /**
     * Download contract PDF
     */
    public function downloadContract(Contract $contract)
    {
        $filePath = Storage::disk('public')->path($contract->contract_path);
        
        if (!file_exists($filePath)) {
            throw new \Exception('El archivo del contrato no existe');
        }

        return response()->download($filePath, 'contrato-prestamo-' . $contract->loan_id . '.pdf');
    }

    /**
     * Check if contract exists for loan
     */
    public function hasContract(Loan $loan): bool
    {
        return $loan->contract()->exists();
    }

    /**
     * Get contract for loan
     */
    public function getContract(Loan $loan): ?Contract
    {
        return $loan->contract;
    }
}
