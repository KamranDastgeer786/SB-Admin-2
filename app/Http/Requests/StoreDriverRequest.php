<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDriverRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Change this if you want to add authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            // Personal Information
            'name' => 'required|string|max:255',
            'date_of_birth' => 'required|date',
            // 'contact_number' => 'required|digits_between:10,15',
            'contact_number' => 'required',
            'email' => 'required|email|unique:drivers,email,' . $this->route('driver'),

            // License Information
            'license_number' => 'required|string|max:255',
            'license_issuing_state' => 'required|string|max:255',
            // 'license_expiry_date' => 'required|date|after:today',
            'license_expiry_date' => 'required|date',

            // Vehicle Information
            'vehicle_make_model' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255',
            'insurance_details' => 'required|string',

            // Emergency Contact
            'emergency_contact_name' => 'required|string|max:255',
            'emergency_contact_number' => 'required',
            'emergency_contact_relationship' => 'required|string|max:255',
        ];
    }

    /**
     * Get the custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'name' => 'full name',
            'date_of_birth' => 'date of birth',
            'contact_number' => 'contact number',
            'email' => 'email address',
            'license_number' => 'license number',
            'license_issuing_state' => 'license issuing state',
            'license_expiry_date' => 'license expiry date',
            'vehicle_make_model' => 'vehicle make & model',
            'vehicle_registration_number' => 'vehicle registration number',
            'insurance_details' => 'insurance details',
            'emergency_contact_name' => 'emergency contact name',
            'emergency_contact_number' => 'emergency contact number',
            'emergency_contact_relationship' => 'relationship with driver',
        ];
    }

    /**
     * Get the custom error messages for validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'The full name field is required.',
            'date_of_birth.required' => 'The date of birth field is required.',
            'contact_number.required' => 'The contact number field is required.',
            'contact_number.digits_between' => 'The contact number must be between 10 and 15 digits.',
            'email.required' => 'The email address field is required.',
            'email.email' => 'The email address must be a valid email address.',
            'email.unique' => 'The email address is already taken.',
            'license_number.required' => 'The license number field is required.',
            'license_issuing_state.required' => 'The license issuing state field is required.',
            'license_expiry_date.required' => 'The license expiry date field is required.',
            'license_expiry_date.date' => 'The license expiry date must be a valid date.',
            'license_expiry_date.after' => 'The license expiry date must be a date after today.',
            'vehicle_make_model.required' => 'The vehicle make & model field is required.',
            'vehicle_registration_number.required' => 'The vehicle registration number field is required.',
            'insurance_details.required' => 'The insurance details field is required.',
            'emergency_contact_name.required' => 'The emergency contact name field is required.',
            'emergency_contact_number.required' => 'The emergency contact number field is required.',
            'emergency_contact_number.digits_between' => 'The emergency contact number must be between 10 and 15 digits.',
            'emergency_contact_relationship.required' => 'The relationship with driver field is required.',
        ];
    }
}