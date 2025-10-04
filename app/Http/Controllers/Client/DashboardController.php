<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\LoanApplication;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class DashboardController extends Controller
{
    /**
     * Display the client dashboard.
     */
    public function index(Request $request): RedirectResponse
    {
        $user = $request->user();
        
        // Get or create client profile
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

        // Check if has active loans - if yes, redirect to loans section
        $activeLoans = $client->loans()->whereIn('status', ['active', 'approved'])->count();
        
        if ($activeLoans > 0) {
            return redirect()->route('client.loans.index');
        }
        
        // Otherwise, redirect to applications section (default)
        return redirect()->route('client.applications.index');
    }
}
