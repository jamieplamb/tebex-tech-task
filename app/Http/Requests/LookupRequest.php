<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class LookupRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'type' => 'required|string|in:minecraft,steam,xbl',
            'id' => 'required_without:username|string|nullable',
            'username' => 'required_without:id|string|nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'type.required' => 'A :attribute is required in all requests.',
            'type.in' => 'The :attribute must be either of :values',
            'username.required_without' => 'A :attribute is required when an ID is not provided.',
            'id.required_without' => 'An :attribute is required when a username is not provided.',
        ];
    }
}
