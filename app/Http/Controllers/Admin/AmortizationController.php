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
     */
    public function updatePayment(Request $request, AmortizationSchedule $schedule)
    {
        $request->validate([
            'amount_paid' => 'required|numeric|min:0|max:' . $schedule->payment_amount,
            'payment_date' => 'nullable|date',
            'notes' => 'nullable|string|max:500'
        ]);

        $schedule->update([
            'amount_paid' => $request->amount_paid,
            'payment_date' => $request->payment_date,
            'notes' => $request->notes,
            'status' => $request->amount_paid >= $schedule->payment_amount ? 'paid' : 
                       ($request->amount_paid > 0 ? 'partial' : 'pending')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pago actualizado exitosamente',
            'status' => $schedule->status
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
