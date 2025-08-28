<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Cambiar según tu lógica de autorización
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'equipment_type_id' => 'required|exists:equipment_types,id',
            'code' => 'required|string|max:20|unique:equipment,code',
            'brand' => 'required|string|max:100',
            'model' => 'required|string|max:100',
            'year' => 'required|integer|min:1990|max:' . (date('Y') + 1),
            'status' => 'required|in:active,maintenance,inactive,retired',
            'location' => 'nullable|string|max:150',
            'hours_worked' => 'nullable|numeric|min:0',
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
            'code.unique' => 'Este código de equipo ya existe.',
            'brand.required' => 'La marca es obligatoria.',
            'model.required' => 'El modelo es obligatorio.',
            'year.required' => 'El año es obligatorio.',
            'year.min' => 'El año debe ser mayor a 1990.',
            'year.max' => 'El año no puede ser mayor al próximo año.',
            'status.required' => 'Debe seleccionar un estado.',
            'status.in' => 'El estado seleccionado no es válido.',
            'hours_worked.numeric' => 'Las horas trabajadas deben ser un número.',
            'hours_worked.min' => 'Las horas trabajadas no pueden ser negativas.',
        ];
    }
}
