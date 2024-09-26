<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAssignmentRecordRequest extends FormRequest
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
            'assigned_to' => 'required|exists:users,id',
            'date_of_assignment' => 'required|date',
            'ppe_condition' => 'required|string|max:255',
            'maintenance_due_date' => 'nullable|date',
            'ppe_equipment_id' => 'required|exists:ppe_equipment,id',
        ];
    }
}
