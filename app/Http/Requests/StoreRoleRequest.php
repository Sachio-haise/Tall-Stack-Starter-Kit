<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        $rules =[
            'name' => 'required|lowercase',
            'permission' => 'nullable',
        ];

        return $rules;
    }

    public function messages()
    {
        return [
            'name.required' => 'The role must define!',
            'name.lowercase' => 'The role must be lowercase.',
        ];
    }
}
