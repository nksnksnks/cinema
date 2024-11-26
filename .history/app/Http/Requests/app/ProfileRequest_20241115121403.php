<?php

namespace App\Http\Requests\app;

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
            'age' => 'required|integer|min:18',
            'phone_number' => 'required|string|max:15',
            'avatar' => 'nullable|string|max:255',  // avatar có thể là URL hoặc đường dẫn ảnh
        ];
    }
}
