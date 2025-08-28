<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ajustar según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        // Obtener el ID del equipo que se está editando
        $equipmentId = $this->route('equipment')->id;

        return [
            'equipment_type_id' => 'required|exists:equipment_types,id',

            // ** UNIQUE excluye el registro actual **
            'code' => [
                'required',
                'string',
                'max:20',
                Rule::unique('equipment', 'code')->ignore($equipmentId)
            ],

            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'status' => 'required|in:active,maintenance,inactive,retired',
            'location' => 'nullable|string|max:150',

            // Especificaciones técnicas (opcionales en update)
            'length' => 'nullable|numeric|min:0|max:50',
            'width' => 'nullable|numeric|min:0|max:20',
            'height' => 'nullable|numeric|min:0|max:20',
            'weight' => 'nullable|numeric|min:0|max:500',
            'fuel_type' => 'nullable|in:diesel,gasolina,electrico,hibrido',

            // Capacidades
            'engine_power' => 'nullable|numeric|min:0|max:2000',
            'fuel_capacity' => 'nullable|numeric|min:0|max:5000',
            'bucket_capacity' => 'nullable|numeric|min:0|max:50',
            'max_load' => 'nullable|numeric|min:0|max:200',

            // Fechas de mantenimiento
            'last_maintenance' => 'nullable|date|before_or_equal:today',
            'next_maintenance' => 'nullable|date|after:today',
            'notes' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Get custom error messages.
     */
    public function messages(): array
    {
        return [
            'equipment_type_id.required' => 'Debe seleccionar un tipo de equipo.',
            'equipment_type_id.exists' => 'El tipo de equipo seleccionado no es válido.',
            'code.required' => 'El código del equipo es obligatorio.',
            'code.unique' => 'Este código de equipo ya existe en otro registro.',
            'brand.required' => 'La marca es obligatoria.',
            'model.required' => 'El modelo es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.min' => 'El año debe ser mayor a 1990.',
            'year.max' => 'El año no puede ser mayor al próximo año.',
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',

            // Validaciones de especificaciones
            'length.numeric' => 'El largo debe ser un número válido.',
            'length.max' => 'El largo no puede ser mayor a 50 metros.',
            'width.numeric' => 'El ancho debe ser un número válido.',
            'width.max' => 'El ancho no puede ser mayor a 20 metros.',
            'height.numeric' => 'La altura debe ser un número válido.',
            'height.max' => 'La altura no puede ser mayor a 20 metros.',
            'weight.numeric' => 'El peso debe ser un número válido.',
            'weight.max' => 'El peso no puede ser mayor a 500 toneladas.',

            'fuel_type.in' => 'El tipo de combustible seleccionado no es válido.',

            // Fechas
            'last_maintenance.date' => 'La fecha de último mantenimiento debe ser válida.',
            'last_maintenance.before_or_equal' => 'La fecha de último mantenimiento no puede ser futura.',
            'next_maintenance.date' => 'La fecha de próximo mantenimiento debe ser válida.',
            'next_maintenance.after' => 'La fecha de próximo mantenimiento debe ser futura.',

            'notes.max' => 'Las notas no pueden exceder 1000 caracteres.',
        ];
    }

    /**
     * Configure the validator instance.
     */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            // Validación personalizada: next_maintenance después de last_maintenance
            if ($this->last_maintenance && $this->next_maintenance) {
                if ($this->next_maintenance <= $this->last_maintenance) {
                    $validator->errors()->add(
                        'next_maintenance',
                        'La fecha de próximo mantenimiento debe ser posterior al último mantenimiento.'
                    );
                }
            }
        });
    }
}
