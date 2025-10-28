<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Loan;
use App\Models\AmortizationSchedule;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\Pdf;

class AmortizationController extends Controller
{
    /**
     * Display the amortization schedule for a loan.
     */
    public function show(Loan $loan)
    {
        $loan->load(['client.user', 'loanApplication', 'amortizationSchedule' => function($query) {
            $query->orderBy('period_number');
        }]);

        return view('admin.amortization.show', compact('loan'));
    }

    /**
     * Update a specific payment in the amortization schedule.
     * Handles overpayments and applies to future payments.
     */
    public function updatePayment(Request $request, AmortizationSchedule $schedule)
    {
        \Log::info('Payment update request received', [
            'all_request_data' => $request->all(),
            'amount_paid' => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes
        ]);
        
        $request->validate([
            'amount_paid' => 'required|numeric|min:0',
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $amountPaid = (float) $request->amount_paid;
        $originalPaymentAmount = $schedule->payment_amount;

        // Update current payment
        if ($amountPaid >= $originalPaymentAmount) {
            // Full payment or overpayment
            $schedule->update([
                'amount_paid' => $originalPaymentAmount,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
                'status' => 'paid'
            ]);

            // Calculate excess amount to apply to future payments
            $excessAmount = $amountPaid - $originalPaymentAmount;
            
            if ($excessAmount > 0) {
                // Get all future unpaid schedules ordered by period
                $futureSchedules = AmortizationSchedule::where('loan_id', $schedule->loan_id)
                    ->where('period_number', '>', $schedule->period_number)
                    ->where('status', '!=', 'paid')
                    ->orderBy('period_number')
                    ->get();
                
                $remainingExcess = $excessAmount;
                
                // Apply excess to future payments
                foreach ($futureSchedules as $futureSchedule) {
                    if ($remainingExcess <= 0) break;
                    
                    $remainingPayment = $futureSchedule->payment_amount - $futureSchedule->amount_paid;
                    
                    if ($remainingExcess >= $remainingPayment) {
                        // This payment will be fully paid
                        $futureSchedule->update([
                            'amount_paid' => $futureSchedule->payment_amount,
                            'status' => 'paid',
                            'notes' => ($futureSchedule->notes ?? '') . ' | Pago adelantado aplicado'
                        ]);
                        $remainingExcess -= $remainingPayment;
                    } else {
                        // Partial payment
                        $futureSchedule->update([
                            'amount_paid' => $futureSchedule->amount_paid + $remainingExcess,
                            'status' => 'partial',
                            'notes' => ($futureSchedule->notes ?? '') . ' | Pago adelantado aplicado'
                        ]);
                        $remainingExcess = 0;
                    }
                }
                
                // If there's still excess after applying to all future payments, note it
                if ($remainingExcess > 0) {
                    $notes = $schedule->notes ?? '';
                    $schedule->update([
                        'notes' => $notes . ' | Excedente de $' . number_format($remainingExcess, 2) . ' disponible'
                    ]);
                }
            }
        } else {
            // Partial payment
            $schedule->update([
                'amount_paid' => $amountPaid,
                'payment_date' => $request->payment_date,
                'notes' => $request->notes,
                'status' => 'partial'
            ]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Pago actualizado exitosamente',
            'status' => $schedule->status,
            'excess_applied' => $amountPaid > $originalPaymentAmount ? $amountPaid - $originalPaymentAmount : 0
        ]);
    }

    /**
     * Generate and download PDF of amortization schedule.
     */
    public function downloadPdf(Loan $loan)
    {
        $loan->load(['client.user', 'loanApplication', 'amortizationSchedule' => function($query) {
            $query->orderBy('period_number');
        }]);

        $pdf = Pdf::loadView('admin.amortization.pdf', compact('loan'))
                  ->setPaper('a4', 'portrait');

        return $pdf->download('tabla-amortizacion-prestamo-' . $loan->id . '.pdf');
    }

    /**
     * Regenerate amortization schedule for a loan.
     */
    public function regenerate(Loan $loan)
    {
        $loan->generateAmortizationSchedule();

        return redirect()->route('admin.amortization.show', $loan)
                        ->with('success', 'Tabla de amortización regenerada exitosamente.');
    }
}
