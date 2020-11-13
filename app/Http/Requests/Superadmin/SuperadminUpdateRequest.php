<?php

namespace App\Http\Requests\Superadmin;

use Illuminate\Foundation\Http\FormRequest;

class SuperadminUpdateRequest extends FormRequest
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
            'email' => 'required|unique:users,email,'.$id,
            'password_old' => 'nullable',
            'password' => 'nullable|confirmed',
            'foto' => 'nullable|mimes:jpg,jpeg,gif,png|max:2000',
            'is_active' => 'required'
        ];
    }
}
