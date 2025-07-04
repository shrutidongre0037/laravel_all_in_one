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
        $marketingId = $this->route('marketing')?->id; // Get ID from route model binding

        return [
            'name'    => 'required|string|max:255',
            'email'   => 'required|email|unique:marketings,email,' . $marketingId,
            'phone'   => 'nullable|string|max:20',
            'address' => 'nullable|string|max:100',
            'image'   => 'nullable|image|max:2048',
        ];
    }
}
