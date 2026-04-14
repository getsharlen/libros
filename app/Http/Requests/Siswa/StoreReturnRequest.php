<?php

namespace App\Http\Requests\Siswa;

use Illuminate\Foundation\Http\FormRequest;

class StoreReturnRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'tanggal_kembali' => ['nullable', 'date'],
            'denda' => ['nullable', 'numeric', 'min:0'],
            'catatan_kondisi' => ['nullable', 'string'],
        ];
    }
}
