<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
             'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'status' => 'required|in:pending,In progress,completed',
            'priority' => 'required|in:low,medium,high',
        ];
    }

    public function attributes(): array
    {   
        return[
            'title' => 'Project title',
            'description' => 'Project description',
            'start_date' => 'Start Date',
            'end_date' => 'End Date',
            'status' => 'Status',
            'priority' => 'Priority'
        ];
    }

    public function messages(): array
    {
        return [
            'title.required' => 'Please enter Project title.',
            'title.string'  =>'Project title must be valid string.',
            'title.max' => 'Project title cannot exceed 255 character.',

            'start_date.required' =>'Start Date is required.',
            'start_date.date' => 'Start Date must be valid date.',

            'end_date.required' =>'End Date is required.',
            'end_date.date' => 'End Date must be valid date.',
            'end_date.after_or_equal' => 'End date must be after or equal to the start date.',

            'status.required' => 'Please select a status.',
            'status.in' => 'Selected status is invalid.',

            'priority.required' => 'Please select a priority.',
            'priority.in' => 'Selected priority is invalid.',

        ];      
    }

     public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if (is_numeric($this->title)) {
                $validator->errors()->add('title', 'Project title cannot be only numbers.');
            }

            $bannedWords = ['test', 'demo', 'dummy'];
            foreach ($bannedWords as $word) {
                if (stripos($this->title, $word) !== false) {
                    $validator->errors()->add('title', "The title cannot contain the word '{$word}'.");
                    break;
                }
            }
        });
    }
}
