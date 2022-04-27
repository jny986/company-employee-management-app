<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'numeric', 'exists:employees,id'],
            'first_name' => ['required', 'string'],
            'last_name' => ['required', 'string'],
            'company_id' => ['nullable', 'numeric', 'exists:companies,id'],
            'email' => ['nullable', 'email'],
            'phone' => ['nullable', 'string']
        ];
    }
}
