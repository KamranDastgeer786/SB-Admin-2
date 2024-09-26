<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            //'name' => 'required|max:255',
            // 'email' => 'required|email|unique:users,email,' . Rule::unique('users')->ignore(Auth::user()),
            // 'email' => ['required', 'email', Rule::unique('users', 'email')->ignore(Auth::id())],
            // 'password' => 'nullable|string|min:8|confirmed',
            // 'active' => 'required |in:on,off',
            // 'roles' => 'required',
            // 'profile_media_id' => 'sometimes',

            'name' => 'required|max:255',
            'email' => [ 'required',  'email', Rule::unique('users', 'email')->ignore($this->user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'active' => 'required|in:on,off',
            'roles' => 'required|array',
            'roles.*' => 'exists:roles,id', 
        ];
    }

    public function messages()
    {
        return [

            'name.required' => 'Please Enter Name.',
            'name.max' => 'The Name may not be greater than :max characters.',
            'email.required' => 'Please Enter Email.',
            'email.email' => 'Please Enter a valid Email Address.',
            'email.unique' => 'Provided Email Address Already Exists.',
            'password.min' => 'The Password must be at least :min characters.',
            'password.confirmed' => 'The Password confirmation does not match.',
            'active.required' => 'Please Enter Active.',
            'active.boolean' => 'The Active field must be either true or false.',
            'roles.required' => 'Please Select a Role.',
        ];
    }
}
