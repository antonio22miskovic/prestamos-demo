<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\ClientDocument;
use App\Models\Loan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ApplicationsController extends Controller
{
    /**
     * Display a listing of loan applications with filtering capabilities.
     */
    public function index(Request $request)
    {
        $query = LoanApplication::with(['client.user', 'loan'])
            ->select([
                'id', 'client_id', 'amount', 'term_months', 'purpose', 
                'status', 'created_at', 'submitted_at', 'evaluated_at',
                'evaluation_notes'
            ]);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Ordenar por fecha de creación (más recientes primero)
        $query->orderBy('created_at', 'desc');

        $applications = $query->paginate(15)->withQueryString();

        // Estadísticas rápidas
        $stats = [
            'total' => LoanApplication::count(),
            'pending' => LoanApplication::where('status', 'pending')->count(),
            'approved' => LoanApplication::where('status', 'approved')->count(),
            'rejected' => LoanApplication::where('status', 'rejected')->count(),
            'draft' => LoanApplication::where('status', 'draft')->count(),
        ];

        return view('admin.applications.index', compact('applications', 'stats'));
    }

    /**
     * Get applications data for AJAX requests
     */
    public function getApplicationsData(Request $request)
    {
        $query = LoanApplication::with(['client.user', 'loan'])
            ->select([
                'id', 'client_id', 'amount', 'term_months', 'purpose', 
                'status', 'created_at', 'submitted_at', 'evaluated_at',
                'evaluation_notes'
            ]);

        // Aplicar filtros
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('amount_min')) {
            $query->where('amount', '>=', $request->amount_min);
        }

        if ($request->filled('amount_max')) {
            $query->where('amount', '<=', $request->amount_max);
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('client.user', function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }

        $applications = $query->orderBy('created_at', 'desc')->paginate(10);

        // Calcular estadísticas
        $stats = [
            'total' => LoanApplication::count(),
            'pending' => LoanApplication::where('status', 'pending')->count(),
            'approved' => LoanApplication::where('status', 'approved')->count(),
            'rejected' => LoanApplication::where('status', 'rejected')->count(),
        ];

        return response()->json([
            'html' => view('admin.applications.partials.table', compact('applications'))->render(),
            'pagination' => $applications->appends($request->all())->links()->render(),
            'stats' => $stats
        ]);
    }

    /**
     * Display the specified loan application.
     */
    public function show(LoanApplication $application)
    {
        $application->load([
            'client.user',
            'loan',
            'documents' => function ($query) {
                $query->orderBy('doc_type');
            }
        ]);

        // Calcular pago mensual estimado
        $monthlyPayment = $this->calculateMonthlyPayment(
            $application->amount,
            $application->term_months,
            config('loan.interest_rate', 0.15) // 15% anual por defecto
        );

        return view('admin.applications.show', compact('application', 'monthlyPayment'));
    }

    /**
     * Approve a loan application.
     */
    public function approve(Request $request, LoanApplication $application)
    {
        $request->validate([
            'approved_amount' => 'required|numeric|min:1000|max:1000000',
            'approved_term' => 'required|integer|min:6|max:60',
            'interest_rate' => 'required|numeric|min:0.05|max:0.50',
            'notes' => 'nullable|string|max:1000'
        ]);

        $loan = null;

        DB::transaction(function () use ($request, $application, &$loan) {
            // Actualizar la solicitud
            $application->update([
                'status' => 'approved',
                'evaluated_at' => now(),
                'evaluation_notes' => $request->notes
            ]);

            // Crear el préstamo
            $monthlyPayment = $this->calculateMonthlyPayment(
                $request->approved_amount,
                $request->approved_term,
                $request->interest_rate
            );

            $loan = Loan::create([
                'client_id' => $application->client_id,
                'loan_application_id' => $application->id,
                'amount' => $request->approved_amount,
                'term_months' => $request->approved_term,
                'interest_rate' => $request->interest_rate,
                'monthly_fee' => $monthlyPayment,
                'total_amount' => $monthlyPayment * $request->approved_term,
                'status' => 'approved',
                'start_date' => now(),
                'end_date' => now()->addMonths($request->approved_term),
                'approved_by' => auth()->id(),
                'approved_at' => now()
            ]);

            // Generar la tabla de amortización
            $loan->generateAmortizationSchedule();
        });

        return redirect()->route('admin.amortization.show', $loan)
            ->with('success', 'Solicitud aprobada exitosamente y tabla de amortización generada.');
    }

    /**
     * Reject a loan application.
     */
    public function reject(Request $request, LoanApplication $application)
    {
        $request->validate([
            'rejection_reason' => 'required|string|max:1000'
        ]);

        $application->update([
            'status' => 'rejected',
            'evaluated_at' => now(),
            'evaluation_notes' => $request->rejection_reason
        ]);

        return redirect()->route('admin.applications.index')
            ->with('success', 'Solicitud rechazada exitosamente.');
    }

    /**
     * Download a client document.
     */
    public function downloadDocument(LoanApplication $application, ClientDocument $document): BinaryFileResponse
    {
        // Verificar que el documento pertenece a la aplicación
        if ($document->client_id !== $application->client_id) {
            abort(403, 'No tienes permisos para descargar este documento.');
        }

        // Verificar que el archivo existe
        if (!Storage::disk('private')->exists($document->file_path)) {
            abort(404, 'El archivo no fue encontrado.');
        }

        $filePath = Storage::disk('private')->path($document->file_path);
        
        return response()->download($filePath, $document->original_name);
    }

    /**
     * Calculate monthly payment for a loan.
     */
    private function calculateMonthlyPayment(float $amount, int $termMonths, float $annualRate): float
    {
        $monthlyRate = $annualRate / 12;
        
        if ($monthlyRate == 0) {
            return $amount / $termMonths;
        }
        
        $monthlyPayment = $amount * ($monthlyRate * pow(1 + $monthlyRate, $termMonths)) / 
                         (pow(1 + $monthlyRate, $termMonths) - 1);
        
        return round($monthlyPayment, 2);
    }
}
