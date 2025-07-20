<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDevelopmentRequest extends FormRequest
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
        $developmentId = $this->route('development'); // Get ID from route model binding

        return [
           'name'          => 'required|string|max:255',
            'email'         => 'required|email|unique:developments,email,' . $developmentId,
            'phone'         => 'nullable|string|max:20',
            'address'       => 'nullable|string|max:100',
            'image'         => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'department_id' => 'required|exists:departments,id',
            'project_ids'   => 'nullable|array',
            'project_ids.*' => 'exists:projects,id',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'          => 'Please provide a name.',
            'email.required'         => 'Email address is required.',
            'email.email'            => 'The email format is invalid.',
            'email.unique'           => 'This email is already taken.',
            'phone.max'              => 'Phone number can have a maximum of 20 characters.',
            'image.image'            => 'Uploaded file must be an image.',
            'image.mimes'            => 'Allowed image formats: jpg, jpeg, png.',
            'image.max'              => 'Image must be less than 2MB.',
            'department_id.required' => 'Please select a department.',
            'department_id.exists'   => 'The selected department is invalid.',
            'project_ids.array'      => 'Projects must be an array.',
            'project_ids.*.exists'   => 'One or more selected projects are invalid.',
        ];
    }

    public function attributes(): array
    {
        return [
            'name'          => 'Employee Name',
            'email'         => 'Email Address',
            'phone'         => 'Phone Number',
            'address'       => 'Address',
            'image'         => 'Profile Image',
            'department_id' => 'Department',
            'project_ids'   => 'Assigned Projects',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            if (is_numeric($this->name)) {
                $validator->errors()->add('name', 'Employee name cannot be a number.');
            }
        });
    }
}
