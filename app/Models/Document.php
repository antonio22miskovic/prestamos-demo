<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_application_id',
        'doc_type',
        'original_name',
        'file_path',
        'file_size',
        'mime_type',
        'verified',
        'verification_notes',
        'uploaded_at',
    ];

    protected $casts = [
        'verified' => 'boolean',
        'uploaded_at' => 'datetime',
    ];

    /**
     * Get the loan application that owns the document.
     */
    public function loanApplication(): BelongsTo
    {
        return $this->belongsTo(LoanApplication::class);
    }

    /**
     * Get the document type in human readable format.
     */
    public function getDocTypeNameAttribute(): string
    {
        return match($this->doc_type) {
            'id_document' => 'Documento de Identidad',
            'income_proof' => 'Comprobante de Ingresos',
            'address_proof' => 'Comprobante de Domicilio',
            default => 'Documento'
        };
    }

    /**
     * Get the file size in human readable format.
     */
    public function getFileSizeHumanAttribute(): string
    {
        $bytes = $this->file_size;
        $units = ['B', 'KB', 'MB', 'GB'];
        
        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }
        
        return round($bytes, 2) . ' ' . $units[$i];
    }

    /**
     * Get the download URL for the document.
     */
    public function getDownloadUrlAttribute(): string
    {
        return route('documents.download', $this->id);
    }

    /**
     * Check if the document exists in storage.
     */
    public function exists(): bool
    {
        return Storage::disk('private')->exists($this->file_path);
    }

    /**
     * Delete the document file from storage.
     */
    public function deleteFile(): bool
    {
        if ($this->exists()) {
            return Storage::disk('private')->delete($this->file_path);
        }
        return true;
    }
}
