<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateCompanyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return Auth::check();
    }

    public function rules(): array
    {
        return [
            'id' => ['required', 'exists:companies,id', 'numeric'],
            'name' => ['required', 'string'],
            'email' => ['nullable', 'email'],
            'website' => ['nullable', 'url', 'string'],
            'logo' => ['nullable', 'image', 'dimensions:min_width=100,min_height=100'],
        ];
    }
}
