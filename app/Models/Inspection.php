<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Inspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'inspection_date',
        'status',
        'observations',
        'cuchara_checked',
        'llantas_checked',
        'articulacion_checked',
        'cilindro_checked',
        'botellones_checked',
        'zbar_checked',
        'dogbone_checked',
        'brazo_checked',
        'tablero_checked',
        'extintores_checked',
    'epp_complete',
        // Si tienes más campos, agrégalos aquí
//        'checked_items',  // Si existe
//        'total_items',    // Si existe
    ];

    protected $casts = [
        'inspection_date' => 'datetime',
        'inspection_items' => 'array',
        'work_hours' => 'decimal:2',
        'total_items' => 'integer',
        'checked_items' => 'integer',
    ];

    /**
     * Boot method para eventos del modelo
     */

    // Agregar un accessor para calcular el porcentaje dinámicamente
    public function getCompletionPercentageAttribute()
    {
        $checkboxFields = [
            'cuchara_checked',
            'llantas_checked',
            'articulacion_checked',
            'cilindro_checked',
            'botellones_checked',
            'zbar_checked',
            'dogbone_checked',
            'brazo_checked',
            'tablero_checked',
            'extintores_checked',
        ];

        $total = count($checkboxFields);
        $checked = 0;

        foreach ($checkboxFields as $field) {
            if ($this->$field) {
                $checked++;
            }
        }

        return $total > 0 ? round(($checked / $total) * 100, 2) : 0;
    }



    protected static function boot()
    {
        parent::boot();

        static::saving(function ($inspection) {
            // Auto-calcular porcentaje y status antes de guardar
            $inspection->updateStatusFromCompletion();
        });
    }

    /**
     * Método para actualizar el status basado en la completitud
     */
    public function updateStatusFromCompletion(): void
    {
        if ($this->checked_items === $this->total_items) {
            $this->status = 'completed';
        } elseif ($this->checked_items === 0) {
            $this->status = 'pending';
        } else {
            $this->status = 'incomplete';
        }

    }

    /**
     * Método para calcular el porcentaje de completitud
     */
    public function calculateCompletionPercentage(): float
    {

        // Evitar división por cero
        if (!$this->total_items || $this->total_items == 0) {
            return 0;
        }

        return round(($this->checked_items / $this->total_items) * 100, 2);

    }

    /**
     * Relación con Equipment
     */
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    /**
     * Scope para filtrar por status
     */
    public function scopeByStatus($query, $status)
    {
        return $query->where('status', $status);
    }


    /**
     * Scope para inspecciones completadas
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Scope para inspecciones pendientes
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    /**
     * Accessor para obtener el porcentaje formateado
     */
    public function getFormattedCompletionPercentageAttribute()
    {
        return number_format($this->completion_percentage, 1) . '%';
    }

    /**
     * Accessor para obtener el badge de status
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'completed' => 'bg-green-100 text-green-800',
            'incomplete' => 'bg-yellow-100 text-yellow-800',
            'pending' => 'bg-gray-100 text-gray-800',
        ];

        return $badges[$this->status] ?? $badges['pending'];
    }

    /**
     * Accessor para obtener el texto del status
     */
    public function getStatusTextAttribute()
    {
        $texts = [
            'completed' => 'Completada',
            'incomplete' => 'Incompleta',
            'pending' => 'Pendiente',
        ];

        return $texts[$this->status] ?? 'Desconocido';
    }

    /**
     * Método para obtener los items aprobados
     */
    public function getPassedItems(): array
    {
        if (!is_array($this->inspection_items)) {
            return [];
        }

        return array_keys(array_filter($this->inspection_items, fn($value) => $value));
    }

    /**
     * Método para verificar si la inspección está completa
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Método para obtener los items fallidos
     */
    public function getFailedItems(): array
    {
        if (!is_array($this->inspection_items)) {
            return [];
        }

        return array_keys(array_filter($this->inspection_items, fn($value) => !$value));
    }

    public function hasIssues()
    {
        return $this->issues()->exists();
    }

// Útil para saber si tiene problemas

    public function issues()
    {
        return $this->hasMany(InspectionIssue::class);
    }

// Para obtener el conteo

    public function issuesCount()
    {
        return $this->issues()->count();
    }

}
