<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProfileRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'dateofbirth' => 'required|date',
            'sex' => 'required|string|max:10',
            'address' => 'required|string|max:255',
            'avatar' => 'nullable|string|max:255',  // avatar có thể là URL hoặc đường dẫn ảnh
        ];
    }
}
