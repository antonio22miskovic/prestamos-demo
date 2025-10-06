<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AmortizationSchedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'period_number',
        'due_date',
        'beginning_balance',
        'payment_amount',
        'principal_payment',
        'interest_payment',
        'ending_balance',
        'status',
        'amount_paid',
        'payment_date',
        'notes'
    ];

    protected $casts = [
        'due_date' => 'date',
        'payment_date' => 'date',
        'beginning_balance' => 'decimal:2',
        'payment_amount' => 'decimal:2',
        'principal_payment' => 'decimal:2',
        'interest_payment' => 'decimal:2',
        'ending_balance' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Get the loan that owns this amortization schedule entry.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Check if this payment is overdue
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }

    /**
     * Get the remaining balance for this payment
     */
    public function getRemainingBalanceAttribute(): float
    {
        return $this->payment_amount - $this->amount_paid;
    }

    /**
     * Mark this payment as paid
     */
    public function markAsPaid(float $amount, ?string $paymentDate = null): void
    {
        $this->amount_paid = $amount;
        $this->payment_date = $paymentDate ?? now();
        
        if ($amount >= $this->payment_amount) {
            $this->status = 'paid';
        } elseif ($amount > 0) {
            $this->status = 'partial';
        }
        
        $this->save();
    }

    /**
     * Scope for pending payments
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Scope for overdue payments
     */
    public function scopeOverdue($query)
    {
        return $query->where('status', 'pending')
                    ->where('due_date', '<', now());
    }
}
