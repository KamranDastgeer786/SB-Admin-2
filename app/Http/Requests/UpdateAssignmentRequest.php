<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAssignmentRequest extends FormRequest
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
            'driver_profile_id' => 'required|exists:driver_profiles,id',
            'assigned_vehicle' => 'required|string|max:255',
            'route_details' => 'required|string|max:255',
            'incident_reports' => 'nullable|string',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'driver_profile_id.required' => 'The driver profile is required.',
            'driver_profile_id.exists' => 'The selected driver profile does not exist.',
            'assigned_vehicle.required' => 'The assigned vehicle field is required.',
            'route_details.required' => 'The route details field is required.',
        ];
    }
}
