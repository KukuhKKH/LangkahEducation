<?php

namespace App\Http\Requests\PassingGrade;

use Illuminate\Foundation\Http\FormRequest;

class PassingGradeStore extends FormRequest
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
            'prodi' => 'required',
            'passing_grade' => 'required|numeric',
            'universitas_id' => 'required',
            'kelompok_id' => 'required|numeric',
        ];
    }
}
