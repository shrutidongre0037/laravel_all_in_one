<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMarketingRequest extends FormRequest
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
        $marketingId = $this->route('marketing'); // Get ID from route model binding

        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:marketings,email,' . $marketingId,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'image'   => 'nullable|image|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required'     => 'Please enter a name.',
            'name.string'       => 'Name must be a valid string.',
            'name.max'          => 'Name cannot exceed 255 characters.',

            'email.required'    => 'Email is required.',
            'email.email'       => 'Please provide a valid email.',
            'email.unique'      => 'This email is already in use.',

            'phone.max'         => 'Phone number must not exceed 20 characters.',
            'address.max'       => 'Address must not exceed 100 characters.',

            'image.image'       => 'Uploaded file must be an image.',
            'image.max'         => 'Image size should not exceed 2MB.',
        ];
    }

     public function attributes(): array
    {
        return [
            'name'    => 'Marketing Name',
            'email'   => 'Email Address',
            'phone'   => 'Phone Number',
            'address' => 'Postal Address',
            'image'   => 'Profile Image',
        ];
    }

    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (is_numeric($this->name)) {
                $validator->errors()->add('name', 'Name cannot be a number only.');
            }

            if (str_ends_with(strtolower($this->email), '@spam.com')) {
                $validator->errors()->add('email', 'Emails from @spam.com are not allowed.');
            }
        });
    }

}
