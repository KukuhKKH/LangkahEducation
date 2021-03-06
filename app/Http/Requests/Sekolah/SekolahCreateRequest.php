<?php

namespace App\Http\Requests\Sekolah;

use Illuminate\Foundation\Http\FormRequest;

class SekolahCreateRequest extends FormRequest
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
            'name' => 'required',
            'email' => 'required|unique:users,email',
            'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2024',
            'alamat' => 'required',
            'kode_referal' => 'nullable',
            'nisn'  => 'nullable|mimes:xls,xlsx',
        ];
    }
}
