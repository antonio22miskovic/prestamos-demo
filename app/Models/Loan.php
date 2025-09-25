<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Loan extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'loan_application_id',
        'amount',
        'interest_rate',
        'term_months',
        'start_date',
        'end_date',
        'status',
        'monthly_fee',
        'total_amount',
        'approval_note',
        'approved_at',
        'approved_by',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'interest_rate' => 'decimal:2',
        'monthly_fee' => 'decimal:2',
        'total_amount' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'approved_at' => 'datetime',
    ];

    /**
     * Get the client that owns the loan.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the loan application associated with this loan.
     */
    public function loanApplication(): BelongsTo
    {
        return $this->belongsTo(LoanApplication::class);
    }

    /**
     * Get the user who approved this loan.
     */
    public function approvedBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    /**
     * Get all installments for this loan.
     */
    public function installments(): HasMany
    {
        return $this->hasMany(Installment::class);
    }

    /**
     * Get the contract for this loan.
     */
    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    /**
     * Generate installment schedule using French amortization system.
     */
    public function generateInstallments(): void
    {
        $monthlyRate = $this->interest_rate / 12 / 100;
        $principal = $this->amount;
        $months = $this->term_months;
        $monthlyPayment = $this->monthly_fee;

        $balance = $principal;
        $currentDate = $this->start_date;

        for ($i = 1; $i <= $months; $i++) {
            $interestPayment = $balance * $monthlyRate;
            $principalPayment = $monthlyPayment - $interestPayment;
            $balance -= $principalPayment;

            $this->installments()->create([
                'number' => $i,
                'due_date' => $currentDate->copy()->addMonths($i),
                'principal' => round($principalPayment, 2),
                'interest' => round($interestPayment, 2),
                'total' => round($monthlyPayment, 2),
                'status' => 'pending',
            ]);
        }
    }

    /**
     * Calculate remaining balance.
     */
    public function getRemainingBalanceAttribute(): float
    {
        $paidPrincipal = $this->installments()
            ->where('status', 'paid')
            ->sum('principal');

        return $this->amount - $paidPrincipal;
    }

    /**
     * Get overdue installments.
     */
    public function getOverdueInstallmentsAttribute()
    {
        return $this->installments()
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->get();
    }
}
