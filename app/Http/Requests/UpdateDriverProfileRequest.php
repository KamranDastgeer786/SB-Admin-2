<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDriverProfileRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Adjust based on your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'full_name' => 'required|string|max:255',
            'license_number' => 'required|string|max:50|unique:driver_profiles,license_number,' . $this->driverprofile->id,
            'vehicle_information' => 'required|string|max:255',
            'contact_details' => 'required|string|max:255',
        ];
    }

    public function messages()
    {
        return [
            'full_name.required' => 'The full name is required.',
            'license_number.required' => 'The license number is required.',
            'license_number.unique' => 'This license number is already taken.',
            'vehicle_information.required' => 'Vehicle information is required.',
            'contact_details.required' => 'Contact details are required.',
        ];
    }
}
