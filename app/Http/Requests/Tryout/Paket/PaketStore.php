<?php

namespace App\Http\Requests\Tryout\Paket;

use Illuminate\Foundation\Http\FormRequest;

class PaketStore extends FormRequest
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
            'status' => 'required',
            'tgl_awal' => 'required',
            'jam_awal' => 'required',
            'tgl_akhir' => 'required',
            'jam_akhir' => 'required',
            'image' => 'nullable',
            'poin_1' => 'required|integer',
            'poin_2' => 'required|integer',
            'poin_3' => 'required|integer',
            'poin_4' => 'required|integer',
            'url_youtube_saintek' => 'required',
            'url_youtube_soshum' => 'required',
            'interpretasi_1' => 'required',
            'interpretasi_2' => 'required',
            'interpretasi_3' => 'required',
        ];
    }
}
