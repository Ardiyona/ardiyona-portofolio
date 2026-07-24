<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Exists;

class ProjectStoreRequest extends FormRequest
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
            'category_id' => [
                'required',
                Rule::exists('categories', 'id'),
            ],
            'tech_stack_id' => [
                'required',
                'array',
            ],
            'tech_stack_id.*' => [
                Rule::exists('tech-stacks', 'id'),
            ],
            'title' => [
                'required',
                'string',
                'max:100',
            ],
            'description' => [
                'required',
                'string',
                'max:255',
            ]
        ];
    }

    public function messages()
    {
        return [
            'category_id.required'      => 'Kategori harus diisi',
            'category_id.exists'        => 'Kategori yang dipilih tidak valid atau tidak terdaftar.',
            'tech_stack_id.required'   => 'Techstack harus diisi',
            'tech_stack_id.exists'     => 'TechStack yang dipilih tidak valid atau tidak terdaftar.',
            'title.required'            => 'Judul harus diisi',
            'title.string'              => 'Judul harus berupa teks',
            'title.max'                 => 'Judul maksimal 100 karakter',
            'description.required'      => 'Deskripsi harus diisi',
            'description.string'        => 'Deskripsi harus berupa teks',
            'description.max'           => 'Deskripsi maksimal 255 karakter',
        ];
    }
}
