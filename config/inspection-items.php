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
                'filtro_de_aire'=> 'Revisar El Filtro De Aire Con El Indicador De Restricción De Admisión',
                'reservorio_de_grasa' => 'Verificar Nivel De Grasa En El Reservorio De Engrase Automático',
                'bornes_de_bateria' => 'Revisar Los Bornes De Las Baterías',
                'mangueras_de_admision' => 'Revisar El Estado De Mangueras Flexibles De Admisión',
                'gatas'=> 'Gatas delanteras y posteriores'
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

    // Configuración adicional
    'settings' => [
        'require_all_items' =>true, // Todos los items son obligatorios
        'allow_partial_sections' => false, // No permitir secciones parciales
        'show_progress_by_section' =>true, // Mostrar progreso por sección
    ]
];
