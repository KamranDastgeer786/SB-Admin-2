<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentViewRequest extends FormRequest
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
            'date_time' => 'required|date_format:Y-m-d\TH:i',
            'status' => 'required|in:Pending,Reviewed,Closed',
            'assigned_reviewer' => 'required|exists:users,id'
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'date_time.required' => 'The date and time field is required.',
            'date_time.date' => 'The date and time must be a valid date.',
            'status.required' => 'The status field is required.',
            'status.in' => 'The selected status is invalid.',
            'assigned_reviewer.required' => 'The assigned reviewer field is required.',
            'assigned_reviewer.exists' => 'The selected reviewer does not exist.'
        ];
    }
}
