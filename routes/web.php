<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

// Redirect after login based on role
Route::get('/dashboard', function () {
    $user = auth()->user();
    
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    } elseif ($user->role === 'client') {
        return redirect()->route('client.dashboard');
    }
    
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin Routes
Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard principal - redirige a solicitudes por defecto
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    
    // Gestión de Solicitudes (página por defecto)
    Route::get('/applications', [App\Http\Controllers\Admin\ApplicationsController::class, 'index'])->name('applications.index');
    Route::get('/applications/data', [App\Http\Controllers\Admin\ApplicationsController::class, 'getApplicationsData'])->name('applications.data');
    Route::get('/applications/{application}', [App\Http\Controllers\Admin\ApplicationsController::class, 'show'])->name('applications.show');
    Route::patch('/applications/{application}/approve', [App\Http\Controllers\Admin\ApplicationsController::class, 'approve'])->name('applications.approve');
    Route::patch('/applications/{application}/reject', [App\Http\Controllers\Admin\ApplicationsController::class, 'reject'])->name('applications.reject');
    Route::get('/applications/{application}/download/{document}', [App\Http\Controllers\Admin\ApplicationsController::class, 'downloadDocument'])->name('applications.download-document');
    
    // Gestión de Clientes
    Route::get('/clients', [App\Http\Controllers\Admin\ClientsController::class, 'index'])->name('clients.index');
    Route::get('/clients/{client}', [App\Http\Controllers\Admin\ClientsController::class, 'show'])->name('clients.show');
    
    // Estadísticas y Reportes
    Route::get('/statistics', [App\Http\Controllers\Admin\StatisticsController::class, 'index'])->name('statistics.index');
    Route::get('/statistics/export', [App\Http\Controllers\Admin\StatisticsController::class, 'export'])->name('statistics.export');
    
    // Configuration
    Route::get('/configuration', [App\Http\Controllers\Admin\ConfigurationController::class, 'index'])->name('configuration.index');
    Route::put('/configuration', [App\Http\Controllers\Admin\ConfigurationController::class, 'update'])->name('configuration.update');
    
    // Amortization Routes
    Route::get('/loans/{loan}/amortization', [App\Http\Controllers\Admin\AmortizationController::class, 'show'])->name('amortization.show');
    Route::patch('/amortization/{schedule}/payment', [App\Http\Controllers\Admin\AmortizationController::class, 'updatePayment'])->name('amortization.update-payment');
    Route::get('/loans/{loan}/amortization/pdf', [App\Http\Controllers\Admin\AmortizationController::class, 'downloadPdf'])->name('amortization.download-pdf');
    Route::post('/loans/{loan}/amortization/regenerate', [App\Http\Controllers\Admin\AmortizationController::class, 'regenerate'])->name('amortization.regenerate');
    
    // Contract Routes
    Route::get('/contracts', [App\Http\Controllers\Admin\ContractsController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{loan}', [App\Http\Controllers\Admin\ContractsController::class, 'show'])->name('contracts.show');
    Route::get('/contracts/{loan}/download', [App\Http\Controllers\Admin\ContractsController::class, 'download'])->name('contracts.download');
    Route::post('/contracts/{loan}/generate', [App\Http\Controllers\Admin\ContractsController::class, 'generate'])->name('contracts.generate');
});

// Client Routes  
Route::middleware(['auth', 'role:client'])->prefix('client')->name('client.')->group(function () {
    Route::get('/dashboard', [ClientDashboardController::class, 'index'])->name('dashboard');
    
    // Dashboard Sections
    Route::get('/loans', [App\Http\Controllers\Client\LoansController::class, 'index'])->name('loans.index');
    Route::get('/loans/{loan}', [App\Http\Controllers\Client\LoansController::class, 'show'])->name('loans.show');
    
    Route::get('/applications', [App\Http\Controllers\Client\ApplicationsController::class, 'index'])->name('applications.index');
    Route::get('/applications/{application}', [App\Http\Controllers\Client\ApplicationsController::class, 'show'])->name('applications.show');
    Route::get('/documents/{document}/download', [App\Http\Controllers\Client\ApplicationsController::class, 'downloadDocument'])->name('documents.download');
    
    Route::get('/contracts', [App\Http\Controllers\Client\ContractsController::class, 'index'])->name('contracts.index');
    Route::get('/contracts/{contract}', [App\Http\Controllers\Client\ContractsController::class, 'show'])->name('contracts.show');
    Route::get('/contracts/{contract}/download', [App\Http\Controllers\Client\ContractsController::class, 'download'])->name('contracts.download');
    Route::post('/contracts/{loan}/generate', [App\Http\Controllers\Client\ContractsController::class, 'generate'])->name('contracts.generate');
    
    Route::get('/profile', [App\Http\Controllers\Client\ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [App\Http\Controllers\Client\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\Client\ProfileController::class, 'update'])->name('profile.update');
    
    Route::get('/security', [App\Http\Controllers\Client\SecurityController::class, 'index'])->name('security.index');
    Route::patch('/security/password', [App\Http\Controllers\Client\SecurityController::class, 'updatePassword'])->name('security.update-password');
    
    // Loan Application Routes (no email verification required for demo)
    Route::prefix('loan-application')->name('loan-application.')->group(function () {
        Route::get('/', [App\Http\Controllers\Client\LoanApplicationController::class, 'index'])->name('index');
        Route::get('/step1', [App\Http\Controllers\Client\LoanApplicationController::class, 'step1'])->name('step1');
        Route::post('/step1', [App\Http\Controllers\Client\LoanApplicationController::class, 'processStep1'])->name('process-step1');
        Route::get('/step2', [App\Http\Controllers\Client\LoanApplicationController::class, 'step2'])->name('step2');
        Route::post('/step2', [App\Http\Controllers\Client\LoanApplicationController::class, 'processStep2'])->name('process-step2');
        Route::get('/step3', [App\Http\Controllers\Client\LoanApplicationController::class, 'step3'])->name('step3');
        Route::get('/step4', [App\Http\Controllers\Client\LoanApplicationController::class, 'step4'])->name('step4');
        Route::post('/step4', [App\Http\Controllers\Client\LoanApplicationController::class, 'processStep4'])->name('process-step4');
        Route::get('/review', [App\Http\Controllers\Client\LoanApplicationController::class, 'review'])->name('review');
        Route::post('/submit', [App\Http\Controllers\Client\LoanApplicationController::class, 'submit'])->name('submit');
    });
});

// Profile Routes (shared)
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
