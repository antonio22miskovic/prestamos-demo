<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\Loan;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StatisticsController extends Controller
{
    /**
     * Display statistics dashboard with filters.
     */
    public function index(Request $request)
    {
        // Definir rango de fechas por defecto (último mes)
        $defaultFrom = Carbon::now()->subMonth()->startOfDay();
        $defaultTo = Carbon::now()->endOfDay();
        
        $dateFrom = $request->filled('date_from') 
            ? Carbon::parse($request->date_from)->startOfDay() 
            : $defaultFrom;
            
        $dateTo = $request->filled('date_to') 
            ? Carbon::parse($request->date_to)->endOfDay() 
            : $defaultTo;

        // Estadísticas generales
        $generalStats = $this->getGeneralStatistics($dateFrom, $dateTo);
        
        // Estadísticas por estatus de solicitudes
        $applicationStats = $this->getApplicationStatistics($dateFrom, $dateTo);
        
        // Estadísticas por rangos de montos
        $amountRangeStats = $this->getAmountRangeStatistics($dateFrom, $dateTo);
        
        // Estadísticas mensuales para gráficos
        $monthlyStats = $this->getMonthlyStatistics();
        
        // Top clientes por monto prestado
        $topClients = $this->getTopClients($dateFrom, $dateTo);

        return view('admin.statistics.index', compact(
            'generalStats', 
            'applicationStats', 
            'amountRangeStats',
            'monthlyStats',
            'topClients',
            'dateFrom',
            'dateTo'
        ));
    }

    /**
     * Get general statistics.
     */
    private function getGeneralStatistics($dateFrom, $dateTo)
    {
        return [
            'total_applications' => LoanApplication::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'approved_applications' => LoanApplication::where('status', 'approved')
                ->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'rejected_applications' => LoanApplication::where('status', 'rejected')
                ->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'pending_applications' => LoanApplication::where('status', 'pending')
                ->whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'total_amount_requested' => LoanApplication::whereBetween('created_at', [$dateFrom, $dateTo])
                ->sum('amount'),
            'total_amount_approved' => Loan::whereBetween('approved_at', [$dateFrom, $dateTo])
                ->sum('amount'),
            'active_loans' => Loan::where('status', 'active')->count(),
            'total_clients' => Client::whereBetween('created_at', [$dateFrom, $dateTo])->count(),
            'approval_rate' => $this->calculateApprovalRate($dateFrom, $dateTo),
        ];
    }

    /**
     * Get application statistics by status.
     */
    private function getApplicationStatistics($dateFrom, $dateTo)
    {
        return LoanApplication::select('status', DB::raw('count(*) as count'))
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->groupBy('status')
            ->pluck('count', 'status')
            ->toArray();
    }

    /**
     * Get statistics by amount ranges.
     */
    private function getAmountRangeStatistics($dateFrom, $dateTo)
    {
        $ranges = [
            '1K-10K' => [1000, 10000],
            '10K-50K' => [10000, 50000],
            '50K-100K' => [50000, 100000],
            '100K-500K' => [100000, 500000],
            '500K+' => [500000, PHP_INT_MAX],
        ];

        $stats = [];
        foreach ($ranges as $label => $range) {
            $stats[$label] = LoanApplication::whereBetween('created_at', [$dateFrom, $dateTo])
                ->whereBetween('amount', $range)
                ->count();
        }

        return $stats;
    }

    /**
     * Get monthly statistics for the last 12 months.
     */
    private function getMonthlyStatistics()
    {
        $months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $date = Carbon::now()->subMonths($i);
            $startOfMonth = $date->copy()->startOfMonth();
            $endOfMonth = $date->copy()->endOfMonth();
            
            $months->push([
                'month' => $date->format('M Y'),
                'applications' => LoanApplication::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                'approved' => LoanApplication::where('status', 'approved')
                    ->whereBetween('created_at', [$startOfMonth, $endOfMonth])->count(),
                'amount_requested' => LoanApplication::whereBetween('created_at', [$startOfMonth, $endOfMonth])
                    ->sum('amount'),
                'amount_approved' => Loan::whereBetween('approved_at', [$startOfMonth, $endOfMonth])
                    ->sum('amount'),
            ]);
        }

        return $months;
    }

    /**
     * Get top clients by total borrowed amount.
     */
    private function getTopClients($dateFrom, $dateTo, $limit = 10)
    {
        return Client::select([
                'clients.id',
                'clients.document_number',
                'users.name',
                'users.email',
                DB::raw('SUM(loans.amount) as total_borrowed'),
                DB::raw('COUNT(loans.id) as loan_count')
            ])
            ->join('users', 'clients.user_id', '=', 'users.id')
            ->join('loans', 'clients.id', '=', 'loans.client_id')
            ->whereBetween('loans.approved_at', [$dateFrom, $dateTo])
            ->whereIn('loans.status', ['approved', 'active', 'paid'])
            ->groupBy('clients.id', 'clients.document_number', 'users.name', 'users.email')
            ->orderBy('total_borrowed', 'desc')
            ->limit($limit)
            ->get();
    }

    /**
     * Calculate approval rate.
     */
    private function calculateApprovalRate($dateFrom, $dateTo)
    {
        $totalEvaluated = LoanApplication::whereIn('status', ['approved', 'rejected'])
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        if ($totalEvaluated === 0) {
            return 0;
        }

        $approved = LoanApplication::where('status', 'approved')
            ->whereBetween('created_at', [$dateFrom, $dateTo])
            ->count();

        return round(($approved / $totalEvaluated) * 100, 2);
    }

    /**
     * Export statistics to CSV.
     */
    public function export(Request $request)
    {
        $dateFrom = $request->filled('date_from') 
            ? Carbon::parse($request->date_from)->startOfDay() 
            : Carbon::now()->subMonth()->startOfDay();
            
        $dateTo = $request->filled('date_to') 
            ? Carbon::parse($request->date_to)->endOfDay() 
            : Carbon::now()->endOfDay();

        // Get all data
        $applications = LoanApplication::whereBetween('created_at', [$dateFrom, $dateTo])
            ->with(['client.user', 'loan'])
            ->get();

        $filename = 'reporte-estadisticas-' . date('Y-m-d') . '.csv';
        
        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ];

        $callback = function() use ($applications, $dateFrom, $dateTo) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            
            // Headers
            fputcsv($file, [
                'ID Solicitud',
                'Cliente',
                'Email',
                'Monto Solicitado',
                'Monto Aprobado',
                'Estado',
                'Fecha Solicitud',
                'Fecha Aprobación',
                'Cuotas',
                'Tasa de Interés',
                'Monto Total'
            ]);

            // Data rows
            foreach ($applications as $app) {
                fputcsv($file, [
                    $app->id,
                    $app->client->user->name ?? 'N/A',
                    $app->client->user->email ?? 'N/A',
                    '$' . number_format($app->requested_amount, 2),
                    $app->loan ? '$' . number_format($app->loan->amount, 2) : 'N/A',
                    $this->getStatusLabel($app->status),
                    $app->created_at->format('Y-m-d'),
                    $app->loan && $app->loan->approved_at ? $app->loan->approved_at->format('Y-m-d') : 'N/A',
                    $app->loan ? $app->loan->term_months . ' meses' : 'N/A',
                    $app->loan ? number_format($app->loan->interest_rate, 2) . '%' : 'N/A',
                    $app->loan ? '$' . number_format($app->loan->total_amount, 2) : 'N/A',
                ]);
            }

            // Summary section
            fputcsv($file, []);
            fputcsv($file, ['RESUMEN', '']);
            fputcsv($file, ['Período', $dateFrom->format('Y-m-d') . ' al ' . $dateTo->format('Y-m-d')]);
            fputcsv($file, ['Total Solicitudes', $applications->count()]);
            fputcsv($file, ['Aprobadas', $applications->where('status', 'approved')->count()]);
            fputcsv($file, ['Rechazadas', $applications->where('status', 'rejected')->count()]);
            fputcsv($file, ['Pendientes', $applications->where('status', 'pending')->count()]);
            
            $totalApproved = $applications->sum(function($app) {
                return $app->loan ? $app->loan->amount : 0;
            });
            fputcsv($file, ['Total Monto Aprobado', '$' . number_format($totalApproved, 2)]);

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Get human-readable status label.
     */
    private function getStatusLabel($status)
    {
        $labels = [
            'pending' => 'Pendiente',
            'approved' => 'Aprobada',
            'rejected' => 'Rechazada',
            'active' => 'Activa',
            'paid' => 'Pagada',
            'defaulted' => 'En Mora'
        ];

        return $labels[$status] ?? ucfirst($status);
    }
}
