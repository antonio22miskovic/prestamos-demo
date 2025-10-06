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
     * Display the admin dashboard - redirect to applications by default.
     */
    public function index()
    {
        // Redirigir directamente a la página de solicitudes como página principal
        return redirect()->route('admin.applications.index');
    }
}
