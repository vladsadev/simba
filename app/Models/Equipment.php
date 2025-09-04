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
        'fuel_type',
        'fuel_capacity',
        'last_maintenance',
        'next_maintenance',
        'notes',
        'engine_hours',
        'percussion_hours',
        'position_hours',
    ];

    protected $casts = [
        'year' => 'integer',
        'last_maintenance' => 'date',
        'next_maintenance' => 'date',
        'engine_hours' => 'decimal:1',
        'percussion_hours' => 'decimal:1',
        'position_hours' => 'decimal:1',
    ];

    /**
     * Relaciones
     */
    public function equipmentType(): BelongsTo
    {
        return $this->belongsTo(EquipmentType::class);
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
     * Obtiene la última inspección del equipo
     */
    public function getLastInspectionAttribute()
    {
        return $this->inspections()->latest('inspection_date')->first();
    }

    // Promedio de horas por día en el último mes

    public function inspections(): HasMany
    {
        return $this->hasMany(Inspection::class);
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

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
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
     * Verifica si el equipo necesita mantenimiento próximamente
     */
//    public function needsMaintenanceSoon($daysThreshold = 30): bool
//    {
//        return $this->next_maintenance &&
//            $this->next_maintenance <= now()->addDays($daysThreshold);
//    }

}
