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
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:developments,email,' . $developmentId,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'image'   => 'nullable|image|max:2048',
            'department_id' => 'required|exists:departments,id',
            'project_ids' => 'nullable|array',
        ];
    }
}
