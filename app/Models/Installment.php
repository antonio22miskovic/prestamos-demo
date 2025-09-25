<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Installment extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'number',
        'due_date',
        'principal',
        'interest',
        'total',
        'status',
        'paid_at',
        'amount_paid',
    ];

    protected $casts = [
        'due_date' => 'date',
        'paid_at' => 'date',
        'principal' => 'decimal:2',
        'interest' => 'decimal:2',
        'total' => 'decimal:2',
        'amount_paid' => 'decimal:2',
    ];

    /**
     * Get the loan that owns the installment.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get all payments for this installment.
     */
    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Check if installment is overdue.
     */
    public function isOverdue(): bool
    {
        return $this->status === 'pending' && $this->due_date->isPast();
    }

    /**
     * Get remaining balance for this installment.
     */
    public function getRemainingBalanceAttribute(): float
    {
        return $this->total - $this->amount_paid;
    }

    /**
     * Mark installment as paid.
     */
    public function markAsPaid(float $amount): void
    {
        $this->amount_paid += $amount;
        
        if ($this->amount_paid >= $this->total) {
            $this->status = 'paid';
            $this->paid_at = now();
        }
        
        $this->save();
    }
}
