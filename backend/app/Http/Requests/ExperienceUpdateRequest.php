<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ExperienceUpdateRequest extends FormRequest
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
            'position' => [
                'required',
                'string',
                'max:100',
            ],
            'company' => [
                'required',
                'string',
                'max:100',
            ],
            'location' => [
                'required',
                'string',
                'max:255',
            ],
            'work_arrangement' => [
                'required',
                'in:fulltime,parttime,internship,freelance',
            ],
            'work_style' => [
                'required',
                'in:onsite,hybrid,remote',
            ],
            'is_currently_working' => [
                'required',
                'boolean',
            ],
            'work_start' => [
                'required',
                'date_format:m/Y',
            ],
            'work_end' => [
                'nullable',
                'date_format:m/Y',
            ],
        ];
    }

    public function messages()
    {
        return [
            'position.required'         => 'Posisi harus diisi',
            'position.string'           => 'Posisi harus berupa teks',
            'position.max'              => 'Posisi maksimal 100 karakter',
            'company.required'          => 'Perusahaan harus diisi',
            'company.string'            => 'Perusahaan harus berupa teks',
            'company.max'               => 'Perusahaan maksimal 100 karakter',
            'location.required'         => 'Lokasi harus diisi',
            'location.string'           => 'Lokasi harus berupa teks',
            'location.max'              => 'Lokasi maksimal 255 karakter',
            'work_arrangement.required' => 'Jenis pekerjaan harus diisi',
            'work_arrangement.in'       => 'Jenis pekerjaan yang dipilih tidak valid',
            'work_style.required'       => 'Gaya kerja harus diisi',
            'work_style.in'             => 'Gaya kerja yang dipilih tidak valid',
            'is_currently_working.required' => 'Status masih bekerja harus diisi',
            'is_currently_working.boolean'  => 'Status masih bekerja tidak valid',
            'work_start.required'       => 'Tanggal mulai harus diisi',
            'work_start.date_format'    => 'Format tanggal mulai harus MM/YYYY',
            'work_end.date_format'      => 'Format tanggal selesai harus MM/YYYY',
        ];
    }
}
