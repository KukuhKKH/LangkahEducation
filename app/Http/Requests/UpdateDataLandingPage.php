<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDataLandingPage extends FormRequest
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
            'headline' => 'required',
            'tagline' => 'required',
            'foto_hero' => 'nullable',
            'tentang_kami' => 'required',
            'foto_tentang_kami' => 'nullable',
            'headline_produk' => 'required',
            'headline_blog' => 'required',
            'headline_testimoni' => 'required',
            'deskripsi' => 'required',
            'email' => 'required',
            'alamat' => 'required',
            'noHP' => 'required',
            'akunIG' => 'required',
            'urlIG' => 'required',
            'akunFB' => 'required',
            'urlFB' => 'required',
            'akunTwitter' => 'required',
            'urlTwitter' => 'required',
            'akunLine' => 'required',
            'urlLine' => 'required',
            'akunYoutube' => 'required',
            'urlYoutube' => 'required',
            'akunLinkedin' => 'required',
            'urlLinkedin' => 'required',
        ];
    }
}
