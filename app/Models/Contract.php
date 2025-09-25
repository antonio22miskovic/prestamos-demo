<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'contract_path',
        'signed_by_client',
        'signed_at',
        'signature_meta',
        'signature_ip',
        'terms_accepted',
    ];

    protected $casts = [
        'signed_by_client' => 'boolean',
        'signed_at' => 'datetime',
        'signature_meta' => 'array',
    ];

    /**
     * Get the loan that owns the contract.
     */
    public function loan(): BelongsTo
    {
        return $this->belongsTo(Loan::class);
    }

    /**
     * Get the download URL for the contract.
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('contracts.download', $this->id);
    }

    /**
     * Check if the contract file exists in storage.
     */
    public function exists(): bool
    {
        return Storage::disk('contracts')->exists($this->contract_path);
    }

    /**
     * Sign the contract.
     */
    public function sign(array $signatureData, string $ipAddress): void
    {
        $this->update([
            'signed_by_client' => true,
            'signed_at' => now(),
            'signature_meta' => $signatureData,
            'signature_ip' => $ipAddress,
            'terms_accepted' => 'Acepto los términos y condiciones del contrato de préstamo.',
        ]);
    }

    /**
     * Check if contract is signed.
     */
    public function isSigned(): bool
    {
        return $this->signed_by_client && $this->signed_at !== null;
    }
}
