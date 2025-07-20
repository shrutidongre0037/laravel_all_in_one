<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDepartmentRequest extends FormRequest
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
            'name' => 'required|string|max:255|unique:departments,name',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Please enter the department name.',
            'name.string'   => 'The department name must be a valid string.',
            'name.max'      => 'The department name may not be greater than 255 characters.',
            'name.unique'   => 'This department already exists.',
        ];
    }

     public function attributes(): array
    {
        return [
            'name' => 'Department Name',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator)
        {
            if (is_numeric($this->name)) {
                $validator->errors()->add('name', 'Department name cannot be a number.');
            }
            if (strtolower($this->name) === 'admin') {
                $validator->errors()->add('name', 'You cannot use "admin" as a department name.');
            }
        });
    }
}
