<?php

namespace App\Http\Requests\admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class MovieRequest extends FormRequest
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
        $method = $this->method();

        switch ($method) {
            case 'POST': // Xử lý khi thêm mới (create)
                return [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255|unique:ci_movie,slug', // Bắt buộc và duy nhất theo slug
                    'country_id' => 'required|integer|exists:ci_country,id',
                    'rated_id' => 'required|integer|exists:ci_rated,id',
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'trailer_url' => 'nullable|string',
                    'duration' => 'required|integer',
                    'date' => 'required|date',
                    'performer' => 'nullable|string|max:255',
                    'director' => 'nullable|string|max:255',
                    'description' => 'nullable|string|max:255',
                    'genre_ids' => 'required|array',
                    'genre_ids.*' => 'integer|exists:ci_genre,id', // Kiểm tra từng phần tử trong mảng genre_ids
                ];
            case 'PUT': // Xử lý khi cập nhật (update)
                return [
                    'name' => 'required|string|max:255',
                    'slug' => 'required|string|max:255|unique:ci_movie,slug,' . $this->route('movie'), // Unique bỏ qua slug của phim hiện tại
                    'country_id' => 'required|integer|exists:ci_country,id',
                    'rated_id' => 'required|integer|exists:ci_rated,id',
                    'avatar' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'poster' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:10240',
                    'trailer_url' => 'nullable|string',
                    'duration' => 'required|integer',
                    'date' => 'required|date',
                    'performer' => 'nullable|string|max:255',
                    'director' => 'nullable|string|max:255',
                    'description' => 'nullable|string|max:255',
                    'genre_ids' => 'required|array',
                    'genre_ids.*' => 'integer|exists:ci_genre,id',
                ];
            default:
                return [];
        }
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên phim là bắt buộc.',
            'slug.required' => 'Slug là bắt buộc.',
            'slug.unique' => 'Slug này đã tồn tại.',
            'country_id.required' => 'Vui lòng chọn quốc gia.',
            'country_id.exists' => 'Quốc gia không tồn tại.',
            'rated_id.required' => 'Vui lòng chọn nhãn độ tuổi.',
            'rated_id.exists' => 'Nhãn độ tuổi không tồn tại.',
            'duration.required' => 'Thời lượng phim là bắt buộc.',
            'duration.integer' => 'Thời lượng phải là một số nguyên.',
            'date.required' => 'Ngày phát hành là bắt buộc.',
            'date.date' => 'Định dạng ngày không hợp lệ.',
            'genre_ids.required' => 'Phim phải có ít nhất một thể loại.',
            'genre_ids.*.exists' => 'Thể loại với ID :input không tồn tại.',

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
