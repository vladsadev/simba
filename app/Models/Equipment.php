<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_type_id',
        'code',
        'brand',
        'model',
        'year',
        'status',
        'location',
        'length',
        'width',
        'height',
        'weight',
        'fuel_type',
        'engine_power',
        'fuel_capacity',
        'bucket_capacity',
        'max_load',
        'last_maintenance',
        'next_maintenance',
        'notes'
    ];

    protected $casts = [
        'year' => 'integer',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
    ];

    /**
     * Relaciones
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
    }


    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
    }

// Nueva relación
    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    /**
     * Scopes útiles
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeOfType($query, $typeName)
    {
        return $query->whereHas('equipmentType', function ($query) use ($typeName) {
            $query->where('name', $typeName);
        });
    }

    /**
     * ⭐ MÉTODOS CALCULADOS para obtener horas trabajadas
     */
    // Total de horas trabajadas (suma de todos los reportes)
    public function getTotalHoursWorkedAttribute(): float
    {
        // Comentado temporalmente si no tienes dailyReports
        // return $this->dailyReports()->sum('hours_worked');
        return 0;
    }

    // Horas trabajadas en un periodo específico
    public function getHoursWorkedInPeriod($startDate, $endDate): float
    {
        // Comentado temporalmente si no tienes dailyReports
        // return $this->dailyReports()
        //     ->whereBetween('date', [$startDate, $endDate])
        //     ->sum('hours_worked');
        return 0;
    }

    // Horas trabajadas en el mes actual
    public function getHoursWorkedThisMonth(): float
    {
        // Comentado temporalmente si no tienes dailyReports
        // return $this->dailyReports()
        //     ->whereYear('date', now()->year)
        //     ->whereMonth('date', now()->month)
        //     ->sum('hours_worked');
        return 0;
    }

    // Promedio de horas por día en el último mes
    public function getAverageHoursPerDay(): float
    {
        // Comentado temporalmente si no tienes dailyReports
        // $reports = $this->dailyReports()
        //     ->where('date', '>=', now()->subMonth())
        //     ->get();
        // return $reports->isEmpty() ? 0 : $reports->avg('hours_worked');
        return 0;
    }

    /**
     * Obtiene la última inspección del equipo
     */
    public function getLastInspectionAttribute()
    {
        return $this->inspections()->latest('inspection_date')->first();
    }

    /**
     * Verifica si el equipo necesita inspección
     */
    public function needsInspection($daysThreshold = 7): bool
    {
        $lastInspection = $this->last_inspection;

        if (!$lastInspection) {
            return true; // Sin inspecciones
        }

        return $lastInspection->inspection_date->addDays($daysThreshold) < now();
    }

    /**
     * -------
     * Obtiene el último mantenimiento del equipo
     */
    public function getLastMaintenanceAttribute()
    {
        return $this->maintenances()
            ->where('scheduled_date', '<=', now())
            ->latest('scheduled_date')
            ->first();
    }

    /**
     * Verifica si el equipo necesita mantenimiento próximamente
     */
    public function needsMaintenanceSoon($daysThreshold = 30): bool
    {
        return $this->next_maintenance &&
            $this->next_maintenance <= now()->addDays($daysThreshold);
    }

    /**
     * Scope para equipos que necesitan inspección
     */
    public function scopeNeedsInspection($query, $daysThreshold = 7)
    {
        return $query->whereDoesntHave('inspections')
            ->orWhereHas('inspections', function ($q) use ($daysThreshold) {
                $q->where('inspection_date', '<', now()->subDays($daysThreshold))
                    ->whereIn('id', function ($subQuery) {
                        $subQuery->selectRaw('MAX(id)')
                            ->from('inspections')
                            ->whereColumn('equipment_id', 'equipment.id');
                    });
            });
    }

    /**
     * Scope para equipos con mantenimiento próximo
     */
    public function scopeUpcomingMaintenance($query, $daysThreshold = 30)
    {
        return $query->whereNotNull('next_maintenance')
            ->where('next_maintenance', '<=', now()->addDays($daysThreshold))
            ->where('next_maintenance', '>=', now());
    }

    /**
     * Obtiene el estado visual del equipo (para el dashboard)
     */
    public function getStatusDisplayAttribute(): array
    {
        $statusConfig = [
            'active' => [
                'label' => 'Operativo',
                'color' => 'green',
                'icon' => 'fas fa-check-circle'
            ],
            'maintenance' => [
                'label' => 'En Mantenimiento',
                'color' => 'yellow',
                'icon' => 'fas fa-tools'
            ],
            'inactive' => [
                'label' => 'Inactivo',
                'color' => 'gray',
                'icon' => 'fas fa-pause-circle'
            ],
            'retired' => [
                'label' => 'Retirado',
                'color' => 'red',
                'icon' => 'fas fa-times-circle'
            ],
        ];

        return $statusConfig[$this->status] ?? $statusConfig['inactive'];
    }

    /**
     * Calcula la prioridad de atención del equipo
     */
    public function getAttentionPriorityAttribute(): string
    {
        // Fuera de servicio - prioridad crítica
        if (in_array($this->status, ['inactive', 'retired'])) {
            return 'critical';
        }

        // En mantenimiento - prioridad alta
        if ($this->status === 'maintenance') {
            return 'high';
        }

        // Necesita inspección - prioridad media
        if ($this->needsInspection()) {
            return 'medium';
        }

        // Mantenimiento próximo - prioridad baja
        if ($this->needsMaintenanceSoon()) {
            return 'low';
        }

        return 'normal';
    }

}
