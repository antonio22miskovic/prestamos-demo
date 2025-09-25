<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class LoanApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'loan_data',
        'current_step',
        'status',
        'purpose',
        'amount',
        'term_months',
        'has_previous_loans',
        'evaluation_score',
        'evaluation_notes',
        'rejection_reason',
        'submitted_at',
        'evaluated_at',
    ];

    protected $casts = [
        'loan_data' => 'array',
        'amount' => 'decimal:2',
        'evaluation_score' => 'decimal:2',
        'has_previous_loans' => 'boolean',
        'submitted_at' => 'datetime',
        'evaluated_at' => 'datetime',
    ];

    /**
     * Get the client that owns the loan application.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get all documents for this application.
     */
    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }

    /**
     * Get the loan created from this application.
     */
    public function loan(): HasOne
    {
        return $this->hasOne(Loan::class);
    }

    /**
     * Check if application is complete.
     */
    public function isComplete(): bool
    {
        return $this->current_step >= 4 && $this->status !== 'draft';
    }

    /**
     * Calculate monthly payment based on French amortization system.
     */
    public function calculateMonthlyPayment(float $interestRate): float
    {
        if (!$this->amount || !$this->term_months) {
            return 0;
        }

        $monthlyRate = $interestRate / 12 / 100;
        $principal = $this->amount;
        $months = $this->term_months;

        if ($monthlyRate == 0) {
            return $principal / $months;
        }

        return $principal * ($monthlyRate * pow(1 + $monthlyRate, $months)) / (pow(1 + $monthlyRate, $months) - 1);
    }
}
