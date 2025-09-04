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


            'fuel_type' => 'nullable|in:diesel,gasolina,electrico,hibrido',

            // Capacidades
            'fuel_capacity' => 'nullable|numeric|min:0|max:5000',

            // Fechas de mantenimiento
            'last_maintenance' => 'nullable|date|before_or_equal:today',
            'next_maintenance' => 'nullable|date|after:today',
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


            'fuel_type.in' => 'El tipo de combustible seleccionado no es válido.',
        ];
    }


}
