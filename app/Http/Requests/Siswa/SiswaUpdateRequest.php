<?php

namespace App\Http\Requests\Siswa;

use App\Models\Siswa;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class SiswaUpdateRequest extends FormRequest
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
            'email' => 'required|unique:users,email,'.request()->user_id,
            'nisn' => 'required|numeric',
            'asal_sekolah' => 'required',
            'tanggal_lahir' => 'required',
            'nomor_hp' => 'required|numeric',
            'password_old' => 'nullable',
            'password' => 'nullable|confirmed',
            'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2000',
            'is_active' => 'required'
        ];
    }
}
