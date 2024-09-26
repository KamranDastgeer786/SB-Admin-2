<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClosureDetailRequest extends FormRequest
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
            'incident_view_id' => 'required|exists:incidents_view,id',
            'closing_date' => 'nullable|date',
            'final_report' => 'nullable|string',
            'resolution_summary' => 'nullable|string',
        ];
    }

    /**
     * Customize the error messages for validation.
     */
    public function messages()
    {
        return [
            'incident_view_id.required' => 'The incident view ID is required.',
            'incident_view_id.exists' => 'The selected incident view ID is invalid.',
            'closing_date.date' => 'The closing date must be a valid date.',
            'final_report.string' => 'The final report must be a string.',
            'resolution_summary.string' => 'The resolution summary must be a string.',
        ];
    }
}
