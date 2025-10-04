<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\LoanApplication;
use App\Models\Loan;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // Key metrics
        $totalApplications = LoanApplication::count();
        $pendingApplications = LoanApplication::where('status', 'pending')->count();
        $approvedLoans = Loan::where('status', 'active')->count();
        $totalDisbursed = Loan::where('status', 'active')->sum('amount');
        
        // Recent applications
        $recentApplications = LoanApplication::with(['client.user'])
            ->orderBy('created_at', 'desc')
            ->take(10)
            ->get();

        // Applications by status
        $applicationsByStatus = LoanApplication::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status')
            ->toArray();

        // Monthly disbursements (last 6 months)
        $monthlyDisbursements = Loan::select(
                DB::raw('YEAR(created_at) as year'),
                DB::raw('MONTH(created_at) as month'),
                DB::raw('SUM(amount) as total')
            )
            ->where('status', 'active')
            ->where('created_at', '>=', now()->subMonths(6))
            ->groupBy('year', 'month')
            ->orderBy('year', 'desc')
            ->orderBy('month', 'desc')
            ->get();

        return view('admin.dashboard', compact(
            'totalApplications',
            'pendingApplications', 
            'approvedLoans',
            'totalDisbursed',
            'recentApplications',
            'applicationsByStatus',
            'monthlyDisbursements'
        ));
    }
}
