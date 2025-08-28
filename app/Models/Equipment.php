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

    public function maintenances(): HasMany
    {
        return $this->hasMany(Maintenance::class);
    }

    // ✅ SCOPES CORREGIDOS - usando fechas en lugar de status
    public function scopeMaintenanceOverdue($query)
    {
        return $query->whereHas('maintenances', function ($q) {
            $q->whereNull('completed_date')  // No completado
            ->where('scheduled_date', '<', now());
        });
    }

    public function scopeMaintenanceDueWithin($query, $days = 7)
    {
        $endDate = now()->addDays($days);
        return $query->whereHas('maintenances', function ($q) use ($endDate) {
            $q->whereNull('completed_date')  // No completado
            ->where('scheduled_date', '<=', $endDate);
        });
    }

    // ✅ MÉTODOS CALCULADOS CORREGIDOS - usando fechas en lugar de status
    public function getLastCompletedMaintenanceAttribute()
    {
        return $this->maintenances()
            ->whereNotNull('completed_date')  // ✅ Cambiado: usar completed_date
            ->orderBy('completed_date', 'desc')
            ->first();
    }

    public function getNextScheduledMaintenanceAttribute()
    {
        return $this->maintenances()
            ->whereNull('completed_date')  // ✅ Cambiado: no completado
            ->orderBy('scheduled_date', 'asc')
            ->first();
    }

    public function getPendingMaintenancesCountAttribute(): int
    {
        return $this->maintenances()
            ->whereNull('completed_date')  // ✅ Cambiado: usar fechas
            ->count();
    }

    public function getOverdueMaintenancesCountAttribute(): int
    {
        return $this->maintenances()
            ->whereNull('completed_date')  // ✅ Cambiado: no completado
            ->where('scheduled_date', '<', now())
            ->count();
    }

    public function getMaintenanceCostThisYearAttribute(): float
    {
        return $this->maintenances()
            ->whereNotNull('completed_date')  // ✅ Cambiado: completado
            ->whereYear('completed_date', now()->year)
            ->sum('cost') ?? 0;
    }

    // Método para actualizar cache de fechas de mantenimiento
    public function updateMaintenanceCache(): void
    {
        $lastCompleted = $this->last_completed_maintenance;
        $nextScheduled = $this->next_scheduled_maintenance;

        $this->update([
            'last_maintenance' => $lastCompleted?->completed_date,
            'next_maintenance' => $nextScheduled?->scheduled_date
        ]);
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
}
