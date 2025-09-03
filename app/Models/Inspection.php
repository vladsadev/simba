<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Inspection extends Model
{
    use HasFactory;

   protected $guarded = [];

    protected $casts = [
        'inspection_date' => 'datetime',
        'epp_complete' => 'boolean',

        // Castear TODOS los campos _checked como boolean
        'cuchara_checked' => 'boolean',
        'llantas_checked' => 'boolean',
        'articulacion_checked' => 'boolean',
        'cilindro_checked' => 'boolean',
        'botellones_checked' => 'boolean',
        'zbar_checked' => 'boolean',
        'dogbone_checked' => 'boolean',
        'brazo_checked' => 'boolean',
        'tablero_checked' => 'boolean',
        'extintores_checked' => 'boolean',

        // Nuevos campos
        'nivel_combustible_checked' => 'boolean',
        'nivel_aceite_motor_checked' => 'boolean',
        'nivel_refrigerante_checked' => 'boolean',
        'nivel_aceite_hidraulico_checked' => 'boolean',
        'purgar_agua_filtro_checked' => 'boolean',
        'polvo_valvula_vacio_checked' => 'boolean',
        'correas_alternador_checked' => 'boolean',
        'presencia_fugas_checked' => 'boolean',
        'switch_parqueo_checked' => 'boolean',
        'freno_servicio_checked' => 'boolean',
        'pedales_freno_checked' => 'boolean',
        'bocina_claxon_checked' => 'boolean',
        'luces_delanteras_checked' => 'boolean',
        'paradas_emergencia_checked' => 'boolean',
        'carrete_manguera_checked' => 'boolean',
        'cable_alimentacion_checked' => 'boolean',
        'carrete_posicionamiento_checked' => 'boolean',
        'valvula_antiparalelismo_checked' => 'boolean',
        'protectores_cilindro_checked' => 'boolean',
        'mangueras_hidraulicas_checked' => 'boolean',
        'viga_avance_checked' => 'boolean',
        'cilindro_avance_checked' => 'boolean',
        'freno_servicio_negociable_checked' => 'boolean',
        'freno_parqueo_checked' => 'boolean',
        'controles_perforacion_checked' => 'boolean',
        'bloqueo_energizacion_checked' => 'boolean',
        'paradas_emergencia_final_checked' => 'boolean',
    ];

    /**
     * Relaciones
     */
    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function issues()
    {
        return $this->hasMany(InspectionIssue::class);
    }

    /**
     * Scopes
     */
    public function scopeCompleted($query)
    {
        return $query->where('status', 'completada');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pendiente');
    }

    /**
     * Métodos auxiliares
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completada';
    }

    public function hasIssues(): bool
    {
        return $this->issues()->exists();
    }

    public function issuesCount(): int
    {
        return $this->issues()->count();
    }

    /**
     * Obtener el porcentaje de items completados
     */
    public function getCompletionPercentage(): float
    {
        $totalFields = 0;
        $checkedFields = 0;

        foreach ($this->casts as $field => $type) {
            if (str_ends_with($field, '_checked') && $type === 'boolean') {
                $totalFields++;
                if ($this->$field === true) {
                    $checkedFields++;
                }
            }
        }

        return $totalFields > 0 ? round(($checkedFields / $totalFields) * 100, 2) : 0;
    }
}
