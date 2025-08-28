<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Carbon\Carbon;

class Maintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'user_id',
        'type',
        'scheduled_date',
        'started_date',
        'completed_date',
        'title',
        'description',
        'work_performed',
        'observations',
        'cost',
        'parts_used',
        'duration_hours',
        'next_maintenance_suggested',
        'hours_interval'
    ];

    protected $casts = [
        'scheduled_date' => 'date',
        'started_date' => 'date',
        'completed_date' => 'date',
        'next_maintenance_suggested' => 'date',
        'parts_used' => 'array',
        'cost' => 'decimal:2'
    ];

    // Relaciones
    public function equipment(): BelongsTo
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Scopes basados en el estado del equipo y fechas
    public function scopeCompleted($query)
    {
        return $query->whereNotNull('completed_date');
    }

    public function scopePending($query)
    {
        return $query->whereNull('completed_date')
            ->whereNull('started_date');
    }

    public function scopeInProgress($query)
    {
        return $query->whereNotNull('started_date')
            ->whereNull('completed_date');
    }

    public function scopeOverdue($query)
    {
        return $query->whereNull('completed_date')
            ->where('scheduled_date', '<', now());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors basados en fechas (sin campo status)
    public function getIsOverdueAttribute(): bool
    {
        return is_null($this->completed_date) &&
            $this->scheduled_date < now();
    }

    public function getIsCompletedAttribute(): bool
    {
        return !is_null($this->completed_date);
    }

    public function getIsInProgressAttribute(): bool
    {
        return !is_null($this->started_date) &&
            is_null($this->completed_date);
    }

    public function getIsPendingAttribute(): bool
    {
        return is_null($this->started_date) &&
            is_null($this->completed_date);
    }

    // Status calculado basado en fechas
    public function getStatusAttribute(): string
    {
        if ($this->completed_date) {
            return 'completado';
        }

        if ($this->started_date) {
            return 'en_proceso';
        }

        return 'programado';
    }

    public function getStatusColorAttribute(): string
    {
        return match($this->status) {
            'programado' => $this->is_overdue ? 'red' : 'blue',
            'en_proceso' => 'yellow',
            'completado' => 'green',
            default => 'gray'
        };
    }

    public function getDurationInDaysAttribute(): ?int
    {
        if (!$this->started_date || !$this->completed_date) {
            return null;
        }

        return $this->started_date->diffInDays($this->completed_date);
    }

    // Método para marcar como iniciado
    public function markAsStarted(): void
    {
        $this->update(['started_date' => now()]);
        $this->equipment->update(['status' => 'maintenance']);
    }

    // Método para marcar como completado
    public function markAsCompleted(array $completionData = []): void
    {
        $this->update([
            'completed_date' => now(),
            ...$completionData
        ]);

        // Verificar si hay otros mantenimientos pendientes
        $hasPendingMaintenance = $this->equipment->maintenances()
            ->where('id', '!=', $this->id)
            ->where(function($query) {
                $query->whereNull('completed_date');
            })
            ->exists();

        // Si no hay otros pendientes, cambiar equipo a activo
        if (!$hasPendingMaintenance) {
            $this->equipment->update(['status' => 'active']);
        }
    }
}
