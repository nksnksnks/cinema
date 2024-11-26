<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class CinemaRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        $action = $this->segments()[3];

        switch ($action):
            case ($action == 'create'):
                $rule = [
                    'name' => 'required|unique:ci_cinema,name',
                    'address' => 'required',
                ];
                break;
            case ($action == 'update'):
                $rule = [
                    'name' => 'required',
                    'address' => 'required',
                ];
                break;
            case ($action == 'delete' || $action == 'get'):
                $rule = [
                    'id' => 'required|exists:ci_cinema,id',
                ];
                break;
        endswitch;

        return $rule;
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.unique' => 'Rạp phim đã tồn tại',
            'address.required' => 'Địa chỉ rạp không được bỏ trống',
            'name.required' => 'Tên rạp không được bỏ trống',
            'id.required' => 'Id không được bỏ trống',
            'id.exists' => 'Id không tồn tại'
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
