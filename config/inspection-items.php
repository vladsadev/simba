<?php

return [
    'sections' => [
        // SECCIÓN 1: REVISIÓN ANTES DE ARRANCAR EL MOTOR
        'revision_antes_arrancar' => [
            'title' => 'REVISIÓN ANTES DE ARRANCAR EL MOTOR',
            'items' => [
                'nivel_combustible' => 'Verificar Nivel De Combustible',
                'nivel_aceite_motor' => 'Verificar El Nivel De Aceite De Motor Diésel',
                'nivel_refrigerante' => 'Verificar El Nivel De Refrigerante',
                'nivel_aceite_hidraulico' => 'Verificar El Nivel De Aceite Hidráulico',
                'purgar_agua_filtro' => 'Purgar Agua Del Filtro Separador',
                'polvo_valvula_vacio' => 'Purgar El Polvo De La Válvula De Vacío Del Filtro De Aire',
                'correas_alternador' => 'Revisar Las Correas Del Alternador, Ventilador Y De Combustible',
            ]
        ],

        // SECCIÓN 2: REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR
        'revision_despues_arrancar' => [
            'title' => 'REVISIÓN DESPUÉS DE ARRANCAR EL MOTOR',
            'items' => [
                'presencia_fugas' => 'Presencia de fugas',
                'switch_parqueo' => 'Verificar El Switch De Parqueo (Botón De Parqueo)',
                'freno_servicio' => 'Verificar Freno De Servicio',
                'pedales_freno' => 'Verificar Funcionamiento De Los Pedales De Freno Y Aceleración',
                'bocina_claxon' => 'Verificar Funcionamiento De La Bocina (Claxon)',
                'luces_delanteras' => 'Verificar Luces Delanteras Y Posteriores (Limpiar)',
                'paradas_emergencia' => 'Verificar funcionalidad de paradas de emergencia',
                'carrete_manguera' => 'Verificar funcionalidad del Carrete de manguera de agua',
            ]
        ],

        // SECCIÓN 3: INSPECCIÓN GENERAL
        'inspeccion_general' => [
            'title' => 'INSPECCIÓN GENERAL',
            'items' => [
                'cable_alimentacion' => 'Cable de alimentación',
                'carrete_posicionamiento' => 'Carrete hidráulicos de posicionamiento, sujeción y articulación',
                'valvula_antiparalelismo' => 'Válvula de antiparalelismo',
                'protectores_cilindro' => 'Protectores de cilindro',
                'mangueras_hidraulicas' => 'Mangueras hidráulicas',
                'viga_avance' => 'Viga de avance',
                'cilindro_avance' => 'Cilindro hidráulico de avance',
            ]
        ],

        // SECCIÓN 4: TEMA NO NEGOCIABLES (ANTES DE MOVER EL EQUIPO)
        'temas_no_negociables' => [
            'title' => 'TEMA NO NEGOCIABLES (ANTES DE MOVER EL EQUIPO)',
            'items' => [
                'freno_servicio_negociable' => 'Freno de servicio',
                'freno_parqueo' => 'Freno de parqueo',
                'controles_perforacion' => 'Controles de operación para perforación',
                'bloqueo_energizacion' => 'Bloqueo de energización (Switch Master)',
                'paradas_emergencia_final' => 'Paradas de emergencia.',
            ]
        ],
    ],

    // Mapeo de campos a la base de datos actual
    // Este mapeo te permitirá mantener compatibilidad con tu estructura actual
    'database_mapping' => [
        // Mapeo de los items anteriores que ya tienes en la base de datos
        'cuchara' => 'cuchara_checked',
        'llantas' => 'llantas_checked',
        'articulacion' => 'articulacion_checked',
        'cilindro' => 'cilindro_checked',
        'botellones' => 'botellones_checked',
        'zbar' => 'zbar_checked',
        'dogbone' => 'dogbone_checked',
        'brazo' => 'brazo_checked',
        'tablero' => 'tablero_checked',
        'extintores' => 'extintores_checked',

        // Aquí agregarás el mapeo para los nuevos campos cuando actualices la base de datos
        // Por ejemplo:
        // 'nivel_combustible' => 'nivel_combustible_checked',
        // 'nivel_aceite_motor' => 'nivel_aceite_motor_checked',
        // etc...
    ],

    // Configuración adicional
    'settings' => [
        'require_all_items' => true, // Todos los items son obligatorios
        'allow_partial_sections' => false, // No permitir secciones parciales
        'show_progress_by_section' => true, // Mostrar progreso por sección
    ]
];
