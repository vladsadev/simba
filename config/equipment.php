<?php
// config/equipment.php

return [
    /*
    |--------------------------------------------------------------------------
    | Configuración de Tipos de Equipos
    |--------------------------------------------------------------------------
    |
    | Aquí puedes configurar los íconos y colores para cada tipo de equipo
    | en el dashboard y otras vistas del sistema.
    |
    */

    'type_icons' => [
        // Perforadoras
        'perforadoras' => 'fas fa-hammer',
        'perforadora' => 'fas fa-hammer',
        'drill' => 'fas fa-hammer',
        'simba' => 'fas fa-hammer',

        // Equipos de Acarreo
        'acarreo' => 'fas fa-truck-moving',
        'camion' => 'fas fa-truck-moving',
        'truck' => 'fas fa-truck-moving',
        'volquete' => 'fas fa-truck-moving',

        // Excavadoras
        'excavadora' => 'fas fa-excavator',
        'excavator' => 'fas fa-excavator',
        'pala' => 'fas fa-excavator',

        // Cargadoras
        'cargadora' => 'fas fa-truck-loading',
        'loader' => 'fas fa-truck-loading',
        'cargador' => 'fas fa-truck-loading',

        // Equipos de Construcción
        'compactadora' => 'fas fa-road',
        'compactor' => 'fas fa-road',
        'rodillo' => 'fas fa-road',

        // Grúas y Equipos de Elevación
        'grua' => 'fas fa-crane',
        'crane' => 'fas fa-crane',
        'montacarga' => 'fas fa-crane',

        // Bulldozers y Equipos de Movimiento de Tierra
        'bulldozer' => 'fas fa-tractor',
        'tractor' => 'fas fa-tractor',
        'motoniveladora' => 'fas fa-tractor',

        // Equipos Auxiliares
        'generador' => 'fas fa-plug',
        'generator' => 'fas fa-plug',
        'compresor' => 'fas fa-compress-arrows-alt',
        'compressor' => 'fas fa-compress-arrows-alt',

        // Por defecto
        'default' => 'fas fa-cog',
    ],

    /*
    |--------------------------------------------------------------------------
    | Colores por Estado de Equipo
    |--------------------------------------------------------------------------
    |
    | Configuración de colores para diferentes estados de los equipos
    |
    */

    'status_colors' => [
        'active' => [
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
            'border' => 'border-green-200',
            'icon' => 'text-green-600',
        ],
        'maintenance' => [
            'bg' => 'bg-yellow-100',
            'text' => 'text-yellow-800',
            'border' => 'border-yellow-200',
            'icon' => 'text-yellow-600',
        ],
        'inactive' => [
            'bg' => 'bg-red-100',
            'text' => 'text-red-800',
            'border' => 'border-red-200',
            'icon' => 'text-red-600',
        ],
        'retired' => [
            'bg' => 'bg-gray-100',
            'text' => 'text-gray-800',
            'border' => 'border-gray-200',
            'icon' => 'text-gray-600',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración de Dashboard
    |--------------------------------------------------------------------------
    |
    | Configuraciones específicas para el dashboard
    |
    */

    'dashboard' => [
        // Días para considerar una inspección como "reciente"
        'recent_inspection_days' => 7,

        // Días para considerar un mantenimiento como "próximo"
        'upcoming_maintenance_days' => 30,

        // Días para alertas críticas de inspección
        'critical_inspection_days' => 14,

        // Auto-refresh del dashboard (en minutos, 0 = deshabilitado)
        'auto_refresh_minutes' => 5,

        // Gradientes de colores para cards de tipos de equipos
        'type_gradients' => [
            'perforadoras' => 'from-blue-600/85 to-blue-600',
            'acarreo' => 'from-yellow-600/85 to-yellow-600',
            'excavadoras' => 'from-green-600/85 to-green-600',
            'cargadoras' => 'from-purple-600/85 to-purple-600',
            'default' => 'from-amber-600/85 to-amber-600',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Configuración de Mantenimiento
    |--------------------------------------------------------------------------
    |
    | Intervalos y configuraciones para mantenimientos
    |
    */

    'maintenance' => [
        'intervals' => [
            'diario' => 1,
            'semanal' => 7,
            'quincenal' => 15,
            'mensual' => 30,
            'bimestral' => 60,
            'trimestral' => 90,
            'semestral' => 180,
            'anual' => 365,
        ],

        'types' => [
            'preventivo' => [
                'label' => 'Preventivo',
                'color' => 'blue',
                'icon' => 'fas fa-calendar-check',
            ],
            'correctivo' => [
                'label' => 'Correctivo',
                'color' => 'yellow',
                'icon' => 'fas fa-wrench',
            ],
            'emergencia' => [
                'label' => 'Emergencia',
                'color' => 'red',
                'icon' => 'fas fa-exclamation-triangle',
            ],
            'inspeccion' => [
                'label' => 'Inspección',
                'color' => 'green',
                'icon' => 'fas fa-clipboard-check',
            ],
        ],
    ],
];
