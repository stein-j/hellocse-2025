<?php

namespace App\Http\Requests;

use App\ProfilStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProfilUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'first_name' => ['sometimes', 'required', 'string', 'max:255'],
            'last_name' => ['sometimes', 'required', 'string', 'max:255'],
            'image' => ['sometimes', 'required', Rule::imageFile()],
            'status' => ['sometimes', 'required', Rule::enum(ProfilStatus::class)],
        ];
    }
}
