<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AuditLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'action',
        'model_type',
        'model_id',
        'meta_json',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'meta_json' => 'array',
    ];

    /**
     * Get the user that performed the action.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the related model.
     */
    public function model()
    {
        if ($this->model_type && $this->model_id) {
            return $this->model_type::find($this->model_id);
        }
        return null;
    }

    /**
     * Create an audit log entry.
     */
    public static function log(string $action, $model = null, array $meta = [], ?int $userId = null): self
    {
        return self::create([
            'user_id' => $userId ?? auth()->id(),
            'action' => $action,
            'model_type' => $model ? get_class($model) : null,
            'model_id' => $model?->id,
            'meta_json' => $meta,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Get action description in Spanish.
     */
    public function getActionDescriptionAttribute(): string
    {
        return match($this->action) {
            'loan_application_created' => 'Solicitud de préstamo creada',
            'loan_application_submitted' => 'Solicitud de préstamo enviada',
            'loan_approved' => 'Préstamo aprobado',
            'loan_rejected' => 'Préstamo rechazado',
            'document_uploaded' => 'Documento subido',
            'contract_signed' => 'Contrato firmado',
            'payment_made' => 'Pago realizado',
            'user_login' => 'Inicio de sesión',
            'user_logout' => 'Cierre de sesión',
            default => $this->action
        };
    }
}
