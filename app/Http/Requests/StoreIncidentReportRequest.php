<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreIncidentReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add authorization logic if needed
    }

    public function rules(): array
    {
        return [
            'incident_date_time' => 'required|date_format:Y-m-d\TH:i',
            'location' => 'required|string|max:255',
            'description' => 'required|string',
            'names_individuals_involved' => 'required|string',
            'roles_in_incident' => 'required|string',
            'contact_information' => 'required|string',
            'attachments' => 'nullable|file|mimes:jpg,png,pdf,doc,docx',
            'witness_statements' => 'nullable|string',
            'submitted_by' => 'required|exists:users,id',
            'submission_date' => 'required|date|date_format:Y-m-d',
            'status' => 'required|in:Pending,Reviewed,Closed',
        ];
    }
}