<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CategoryUpdateRequest extends FormRequest
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
        $categoryId = $this->route('categories') ? $this->route('categories')->id : 0;

        return [
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:25|unique:categories,code,' . $categoryId,
        ];
    }

    public function messages()
    {
        return [
            'name.required' => 'Nama kategori harus diisi',
            'name.string' => 'Nama kategori harus berupa teks',
            'name.max' => 'Nama kategori maksimal 255 karakter',
            'code.required' => 'Kode kategori harus diisi',
            'code.string' => 'Kode kategori harus berupa teks',
            'code.max' => 'Kode kategori maksimal 25 karakter',
            'code.unique' => 'Kode kategori sudah digunakan',
        ];
    }
}
