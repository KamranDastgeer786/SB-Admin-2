<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMediaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // You can implement custom authorization logic here
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'file_name' => 'required|string|max:255', // Validates file name as required string
            'file' => 'required|file|max:10240|mimes:jpeg,png,mp4,pdf', // Validates file type and size
        ];
    }

    /**
     * Get custom messages for validation errors.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'file_name.required' => 'The file name is required.',
            'file_name.string' => 'The file name must be a string.',
            'file_name.max' => 'The file name must not exceed 255 characters.',
            'file.required' => 'Please upload a file.',
            'file.file' => 'The uploaded file must be a valid file.',
            'file.max' => 'The file size must not exceed 10MB.',
            'file.mimes' => 'The file must be of type: JPEG, PNG, MP4, PDF.',
        ];
    }
}