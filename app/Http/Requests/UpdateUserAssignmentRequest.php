<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserAssignmentRequest extends FormRequest
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
            'user_id' => 'required|exists:users,id',
            'pp_assigned' => 'required|exists:ppe_equipment,id',
            'assignment_date' => 'required|date',
        ];
    }

    /**
     * Customize the error messages for validation.
     */
    public function messages()
    {
        return [
            'user_id.required' => 'The user ID is required.',
            'user_id.exists' => 'The selected user ID is invalid.',
            'pp_assigned.required' => 'The PPE assigned ID is required.',
            'pp_assigned.exists' => 'The selected PPE assigned ID is invalid.',
            'assignment_date.required' => 'The assignment date is required.',
            'assignment_date.date' => 'The assignment date must be a valid date.',
        ];
    }
}
