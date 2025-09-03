<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Equipment;
use App\Models\Inspection;
use App\Models\InspectionIssue;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class InspectionForm extends Component
{
    // Propiedades públicas (reactivas)
    public Equipment $equipment;
    public $observations = '';
    public $checkedItems = [];
    public $reportedIssues = [];
    public $epp = false;

    // Configuración de inspección
    public $inspectionConfig = [];
    public $sectionProgress = [];

    // Modal de problemas
    public $showIssueModal = false;
    public $currentIssueComponent = '';
    public $currentIssue = [
        'component' => '',
        'tipo_problema' => '',
        'severidad' => 'media',
        'descripcion' => '',
        'accion_recomendada' => 'Monitoreo continuo'
    ];

    // Reglas de validación
    protected $rules = [
        'currentIssue.tipo_problema' => 'required|string',
        'currentIssue.severidad' => 'required|in:baja,media,alta,critica',
        'currentIssue.descripcion' => 'required|string|min:10',
        'currentIssue.accion_recomendada' => 'required|string',
    ];

    protected $messages = [
        'currentIssue.tipo_problema.required' => 'Debe seleccionar el tipo de problema',
        'currentIssue.severidad.required' => 'Debe seleccionar la severidad',
        'currentIssue.descripcion.required' => 'Debe describir el problema',
        'currentIssue.descripcion.min' => 'La descripción debe tener al menos 10 caracteres',
        'currentIssue.accion_recomendada.required' => 'Debe seleccionar una acción recomendada',
    ];

    // Montar el componente con el equipo
    public function mount(Equipment $equipment)
    {
        $this->equipment = $equipment;
        $this->loadInspectionConfig();
        $this->initializeSectionProgress();
    }

    // Cargar configuración desde el archivo
    private function loadInspectionConfig()
    {
        $this->inspectionConfig = config('inspection-items');
    }

    // Inicializar el progreso por sección
    private function initializeSectionProgress()
    {
        foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
            $this->sectionProgress[$sectionKey] = [
                'total' => count($section['items']),
                'checked' => 0,
                'issues' => 0
            ];
        }
    }

    // Actualizar progreso de sección
    private function updateSectionProgress($sectionKey)
    {
        $checked = 0;
        $issues = 0;

        foreach ($this->inspectionConfig['sections'][$sectionKey]['items'] as $itemKey => $itemLabel) {
            if (in_array($itemKey, $this->checkedItems)) {
                $checked++;
            }
            if (isset($this->reportedIssues[$itemKey])) {
                $issues++;
            }
        }

        $this->sectionProgress[$sectionKey]['checked'] = $checked;
        $this->sectionProgress[$sectionKey]['issues'] = $issues;
    }

    // Obtener sección de un item
    private function getItemSection($itemKey)
    {
        foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
            if (array_key_exists($itemKey, $section['items'])) {
                return $sectionKey;
            }
        }
        return null;
    }

    // Propiedad computada para el progreso total
    public function getProgressProperty()
    {
        $totalItems = 0;
        $checkedItems = 0;

        foreach ($this->inspectionConfig['sections'] as $section) {
            $totalItems += count($section['items']);
        }

        $checkedItems = count($this->checkedItems);

        return $totalItems > 0 ? round(($checkedItems / $totalItems) * 100) : 0;
    }

    // Propiedad computada para contar items totales
    public function getTotalItemsProperty()
    {
        $total = 0;
        foreach ($this->inspectionConfig['sections'] as $section) {
            $total += count($section['items']);
        }
        return $total;
    }

    // Propiedad computada para el número de problemas
    public function getIssuesCountProperty()
    {
        return count($this->reportedIssues);
    }

    // Verificar si una sección está completa
    public function isSectionComplete($sectionKey)
    {
        $section = $this->inspectionConfig['sections'][$sectionKey];
        foreach ($section['items'] as $itemKey => $itemLabel) {
            if (!in_array($itemKey, $this->checkedItems) && !isset($this->reportedIssues[$itemKey])) {
                return false;
            }
        }
        return true;
    }

    // Cuando se marca/desmarca un checkbox
    public function toggleItem($key)
    {
        if (in_array($key, $this->checkedItems)) {
            $this->checkedItems = array_values(array_diff($this->checkedItems, [$key]));
        } else {
            $this->checkedItems[] = $key;
            // Si tenía un problema reportado, lo quitamos
            unset($this->reportedIssues[$key]);
        }

        // Actualizar progreso de la sección
        $sectionKey = $this->getItemSection($key);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }
    }

    // Abrir modal para reportar problema
    public function openIssueModal($componentKey)
    {
        // Si el item está marcado como OK, lo desmarcamos
        if (in_array($componentKey, $this->checkedItems)) {
            $this->checkedItems = array_values(array_diff($this->checkedItems, [$componentKey]));
        }

        $this->currentIssueComponent = $componentKey;
        $this->currentIssue['component'] = $componentKey;

        // Si ya había un problema reportado para este componente, cargarlo
        if (isset($this->reportedIssues[$componentKey])) {
            $this->currentIssue = $this->reportedIssues[$componentKey];
        } else {
            // Resetear el formulario
            $this->currentIssue = [
                'component' => $componentKey,
                'tipo_problema' => '',
                'severidad' => 'media',
                'descripcion' => '',
                'accion_recomendada' => 'Monitoreo continuo'
            ];
        }

        $this->showIssueModal = true;
    }

    public function saveIssue()
    {
        $this->validate();

        // Guardar en el array de problemas
        $this->reportedIssues[$this->currentIssueComponent] = $this->currentIssue;

        // Asegurarse de que el item no esté marcado como OK
        $this->checkedItems = array_values(array_diff($this->checkedItems, [$this->currentIssueComponent]));

        // Actualizar progreso de la sección
        $sectionKey = $this->getItemSection($this->currentIssueComponent);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }

        // Cerrar modal
        $this->closeIssueModal();

        // Mensaje de éxito
        session()->flash('issue_saved', 'Problema reportado correctamente');
    }

    public function closeIssueModal()
    {
        $this->showIssueModal = false;
        $this->reset(['currentIssue', 'currentIssueComponent']);
    }

    public function removeIssue($componentKey)
    {
        unset($this->reportedIssues[$componentKey]);

        // Actualizar progreso de la sección
        $sectionKey = $this->getItemSection($componentKey);
        if ($sectionKey) {
            $this->updateSectionProgress($sectionKey);
        }

        session()->flash('issue_removed', 'Problema eliminado');
    }

    // Enviar formulario completo
    public function submit()
    {
        // Validación personalizada
        if (count($this->checkedItems) === 0 && count($this->reportedIssues) === 0) {
            $this->addError('inspection', 'Debe revisar al menos un elemento o reportar problemas encontrados.');
            return;
        }

        // Verificar que todas las secciones estén completas si es requerido
        if ($this->inspectionConfig['settings']['require_all_items']) {
            foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
                if (!$this->isSectionComplete($sectionKey)) {
                    $this->addError('inspection', 'Debe completar todos los elementos de la sección: ' . $section['title']);
                    return;
                }
            }
        }

        DB::beginTransaction();

        try {
            // Preparar datos para guardar
            $inspectionData = [
                'equipment_id' => $this->equipment->id,
                'user_id' => Auth::id(),
                'inspection_date' => now(),
                'status' => $this->determineStatus(),
                'observations' => $this->observations,
                'epp_complete' => $this->epp,
            ];

            // IMPORTANTE: Establecer TODOS los campos booleanos
            // Primero, establecer todos como false por defecto
            foreach ($this->inspectionConfig['sections'] as $sectionKey => $section) {
                foreach ($section['items'] as $itemKey => $itemLabel) {
                    $columnName = $itemKey . '_checked';
                    $inspectionData[$columnName] = false; // Por defecto false
                }
            }

            // Ahora, establecer como true solo los que están marcados
            foreach ($this->checkedItems as $itemKey) {
                $columnName = $itemKey . '_checked';
                $inspectionData[$columnName] = true;
            }

            // Debug para verificar los datos antes de guardar
            \Log::info('Datos de inspección a guardar:', $inspectionData);

            // Crear la inspección
            $inspection = Inspection::create($inspectionData);

            // Guardar los problemas reportados
            foreach ($this->reportedIssues as $issue) {
                InspectionIssue::create([
                    'inspection_id' => $inspection->id,
                    'user_id' => Auth::id(),
                    'component' => $issue['component'],
                    'issue_type' => $issue['tipo_problema'],
                    'severity' => $issue['severidad'],
                    'description' => $issue['descripcion'],
                    'recommended_action' => $issue['accion_recomendada'],
                    'reported_at' => now(),
                    'status' => 'abierto'
                ]);
            }

            DB::commit();

            session()->flash('success', 'Inspección guardada exitosamente');

            return redirect()->route('equipment.show', $this->equipment);

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error al guardar inspección:', ['message' => $e->getMessage()]);
            $this->addError('save', 'Error al guardar la inspección: ' . $e->getMessage());
        }
    }

    // Determinar el estado basado en los problemas
    private function determineStatus()
    {
        if (count($this->reportedIssues) === 0) {
            return 'completada';
        }

        // Verificar si hay problemas críticos
        foreach ($this->reportedIssues as $issue) {
            if ($issue['severidad'] === 'critica') {
                return 'requiere_atencion_urgente';
            }
        }

        return 'completada_con_observaciones';
    }

    // Método de renderizado
    public function render()
    {
        return view('livewire.inspection-form');
    }
}
