<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInventoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'total_equipment' => 'required|integer|min:0',
            'available_stock' => 'required|integer|min:0|lte:total_equipment',
            'maintenance_schedule' => 'required|date|after_or_equal:today',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'total_equipment.required' => 'The total equipment field is required.',
            'total_equipment.integer' => 'The total equipment must be an integer.',
            'total_equipment.min' => 'The total equipment must be at least 0.',
            'available_stock.required' => 'The available stock field is required.',
            'available_stock.integer' => 'The available stock must be an integer.',
            'available_stock.lte' => 'The available stock must be less than or equal to the total equipment.',
            'maintenance_schedule.required' => 'The maintenance schedule date is required.',
            'maintenance_schedule.date' => 'The maintenance schedule must be a valid date.',
            'maintenance_schedule.after_or_equal' => 'The maintenance schedule cannot be a past date.',
        ];
    }
}
