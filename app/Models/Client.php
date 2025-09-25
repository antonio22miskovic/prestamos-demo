<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_type',
        'document_number',
        'address',
        'birthdate',
        'employment',
        'income',
        'expenses',
    ];

    protected $casts = [
        'birthdate' => 'date',
        'income' => 'decimal:2',
        'expenses' => 'decimal:2',
    ];

    /**
     * Get the user that owns the client profile.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get all loan applications for the client.
     */
    public function loanApplications(): HasMany
    {
        return $this->hasMany(LoanApplication::class);
    }

    /**
     * Get all loans for the client.
     */
    public function loans(): HasMany
    {
        return $this->hasMany(Loan::class);
    }

    /**
     * Calculate net income (income - expenses).
     */
    public function getNetIncomeAttribute(): float
    {
        return $this->income - $this->expenses;
    }

    /**
     * Calculate debt-to-income ratio for a given monthly payment.
     */
    public function calculateDebtToIncomeRatio(float $monthlyPayment): float
    {
        if ($this->income <= 0) {
            return 100; // Return 100% if no income
        }

        $totalMonthlyObligations = $this->expenses + $monthlyPayment;
        return ($totalMonthlyObligations / $this->income) * 100;
    }
}
