<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\AmortizationSchedule;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Barryvdh\DomPDF\Facade\Pdf;

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
            ->with(['installments', 'amortizationSchedule', 'loanApplication'])
            ->findOrFail($loanId);

        return view('client.loans.show', compact('client', 'loan'));
    }

    /**
     * Process payment for a specific installment
     */
    public function processPayment(Request $request, Loan $loan)
    {
        $request->validate([
            'installment_id' => 'required|exists:amortization_schedules,id',
            'amount' => 'required|numeric|min:0.01',
            'date' => 'required|date',
            'notes' => 'nullable|string|max:500'
        ]);

        try {
            $schedule = AmortizationSchedule::findOrFail($request->installment_id);
            
            // Verify installment belongs to the loan
            if ($schedule->loan_id != $loan->id) {
                return response()->json([
                    'success' => false,
                    'message' => 'La cuota no pertenece a este préstamo.'
                ], 400);
            }

            $amountPaid = $request->amount;
            $originalPaymentAmount = $schedule->payment_amount;
            $excessAmount = 0;

            // Update current schedule
            if ($amountPaid >= $originalPaymentAmount) {
                $schedule->status = 'paid';
                $excessAmount = $amountPaid - $originalPaymentAmount;
            } else {
                $schedule->status = 'partial';
            }

            $schedule->amount_paid = $request->amount;
            $schedule->payment_date = $request->date;
            $schedule->notes = $request->notes;
            $schedule->save();

            // Apply excess to future schedules
            if ($excessAmount > 0) {
                $remainingExcess = $excessAmount;
                $futureSchedules = AmortizationSchedule::where('loan_id', $loan->id)
                    ->where('id', '>', $schedule->id)
                    ->where('status', 'pending')
                    ->orderBy('id')
                    ->get();

                foreach ($futureSchedules as $futureSchedule) {
                    if ($remainingExcess <= 0) break;

                    $futureAmount = $futureSchedule->payment_amount;
                    
                    if ($remainingExcess >= $futureAmount) {
                        $futureSchedule->status = 'paid';
                        $futureSchedule->amount_paid = $futureAmount;
                        $futureSchedule->payment_date = now();
                        $futureSchedule->notes = 'Pago aplicado por adelantado desde cuota #' . $schedule->period_number;
                        $remainingExcess -= $futureAmount;
                    } else {
                        $futureSchedule->status = 'partial';
                        $futureSchedule->amount_paid = $remainingExcess;
                        $futureSchedule->payment_date = now();
                        $futureSchedule->notes = 'Pago parcial aplicado por adelantado desde cuota #' . $schedule->period_number;
                        $remainingExcess = 0;
                    }

                    $futureSchedule->save();
                }
            }

            // Check if all schedules are paid
            $pendingSchedules = AmortizationSchedule::where('loan_id', $loan->id)
                ->where('status', '!=', 'paid')
                ->count();

            if ($pendingSchedules == 0) {
                $loan->status = 'paid';
                $loan->save();
            }

            return response()->json([
                'success' => true,
                'message' => 'Pago registrado exitosamente. ' . ($excessAmount > 0 ? 'El excedente ha sido aplicado a las cuotas futuras.' : '')
            ]);

        } catch (\Exception $e) {
            \Log::error('Error processing payment: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Hubo un error al procesar el pago. Por favor intenta nuevamente.'
            ], 500);
        }
    }

    /**
     * Download loan statement as PDF
     */
    public function downloadStatement(Request $request, Loan $loan)
    {
        $user = $request->user();
        $client = $user->client;

        // Verify loan belongs to client
        if ($loan->client_id != $client->id) {
            abort(403, 'No tienes permisos para acceder a este préstamo.');
        }

        // Load necessary relationships
        $loan->load(['installments', 'loanApplication']);
        $client->load('user');

        $pdf = Pdf::loadView('client.loans.statement-pdf', compact('loan', 'client'));
        
        $filename = 'Estado_Cuenta_Prestamo_' . str_pad($loan->id, 6, '0', STR_PAD_LEFT) . '_' . now()->format('Y-m-d') . '.pdf';
        
        return $pdf->download($filename);
    }
}