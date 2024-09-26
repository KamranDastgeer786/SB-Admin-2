<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateIncidentReportRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Add authorization logic if needed
    }

    public function rules(): array
    {
        return [

            'incident_date_time' => 'required|date_format:Y-m-d\TH:i', // Ensure the date and time are in correct format
            'location' => 'required|string|max:255', // Location must be a string with a max of 255 characters
            'description' => 'required|string', // Description must be provided
            'names_individuals_involved' => 'required|string', // Ensure consistent field name
            'roles_in_incident' => 'required|string', // Roles must be provided
            'contact_information' => 'required|string', // Contact information must be provided
            'attachments.*' => 'nullable|file|mimes:jpg,png,pdf,doc,docx', // Handle multiple attachments if required
            'witness_statements' => 'nullable|string', // Witness statements can be optional
            'submitted_by' => 'required|exists:users,id', // Ensure the submitted user exists
            'submission_date' => 'required|date|date_format:Y-m-d', // Ensure correct date format for submission
            'status' => 'required|in:Pending,Reviewed,Closed', // Status must be one of the allowed values
        ];
    }
}