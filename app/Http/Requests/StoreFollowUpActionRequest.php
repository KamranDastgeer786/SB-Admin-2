<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFollowUpActionRequest extends FormRequest
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
            'follow_up_date' => 'nullable|date',
            'assigned_user' => 'required|exists:users,id',
            'notes' => 'nullable|string',
        ];
    }

    /**
     * Custom messages for validation errors.
     */
    public function messages(): array
    {
        return [
            'incident_view_id.required' => 'The incident view is required.',
            'incident_view_id.exists' => 'The selected incident view does not exist.',
            'assigned_user.required' => 'The assigned user is required.',
            'assigned_user.exists' => 'The selected user does not exist.',
        ];
    }
}
