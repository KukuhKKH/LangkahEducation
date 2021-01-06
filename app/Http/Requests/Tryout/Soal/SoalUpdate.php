<?php

namespace App\Http\Requests\Tryout\Soal;

use Illuminate\Foundation\Http\FormRequest;

class SoalUpdate extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'soal' => 'required',
            'pembahasan' => 'nullable',
            // 'nilai_benar' => 'required',
            'nilai_salah' => 'required|integer',

            'pilihan1' => 'required',
            'pilihan2' => 'required',
            'pilihan3' => 'required',
            'pilihan4' => 'required',
            'benar' => 'required'
        ];
    }
}
