<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePerformanceRecordRequest extends FormRequest
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
            'on_time_delivery_rate' => 'required|numeric|min:0|max:100',
            'incident_involvements' => 'required|integer|min:0',
            'maintenance_compliance' => 'required|string|max:255',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'driver_profile_id.required' => 'The driver profile is required.',
            'driver_profile_id.exists' => 'The selected driver profile does not exist.',
            'on_time_delivery_rate.required' => 'The on-time delivery rate is required.',
            'on_time_delivery_rate.numeric' => 'The on-time delivery rate must be a number.',
            'on_time_delivery_rate.min' => 'The on-time delivery rate must be at least 0.',
            'on_time_delivery_rate.max' => 'The on-time delivery rate may not be greater than 100.',
            'incident_involvements.required' => 'The number of incident involvements is required.',
            'incident_involvements.integer' => 'The number of incident involvements must be an integer.',
            'incident_involvements.min' => 'The number of incident involvements must be at least 0.',
            'maintenance_compliance.required' => 'The maintenance compliance is required.',
            'maintenance_compliance.string' => 'The maintenance compliance must be a string.',
            'maintenance_compliance.max' => 'The maintenance compliance may not be greater than 255 characters.',
        ];
    }
}
