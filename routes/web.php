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
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
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
