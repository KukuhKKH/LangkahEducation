<?php

namespace App\Http\Requests\Gelombang;

use Illuminate\Foundation\Http\FormRequest;

class GelombangStore extends FormRequest
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
            'nama' => 'required',
            'harga' => 'required',
            'tgl_awal' => 'required',
            'tgl_akhir' => 'required',
            'jenis' => 'required'
        ];
    }
}
