<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePpeEquipmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Add authorization logic if needed
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
           'equipment_name' => 'required|string|max:255',
           'equipment_type' => 'required|string|max:255',
           'serial_number' => 'required|string|max:255|unique:ppe_equipment,serial_number', // corrected table name
           'date_of_purchase' => 'required|date',
        ];
    }
}
