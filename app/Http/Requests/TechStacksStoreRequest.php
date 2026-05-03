<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class TechStacksStoreRequest extends FormRequest
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
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name'  => 'required|string|max:255',
            'code'  => 'required|string|max:25|unique:tech-stacks,code',
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama tech stack harus diisi',
            'name.string' => 'Nama tech stack harus berupa teks',
            'name.max' => 'Nama tech stack maksimal 255 karakter',
            'code.required' => 'Kode tech stack harus diisi',
            'code.string' => 'Kode tech stack harus berupa teks',
            'code.max' => 'Kode tech stack maksimal 25 karakter',
            'code.unique' => 'Kode tech stack sudah digunakan',
        ];
    }
}
