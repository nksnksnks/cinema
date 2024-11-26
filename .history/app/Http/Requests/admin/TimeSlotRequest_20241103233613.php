<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\Response;

class TimeSlotRequest extends FormRequest
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
            case 'POST': // Rules for creating a new time slot
                return [
                    'slot_name' => 'required|string|max:255|unique:time_slots,slot_name',
                    'start_time' => 'required|date_format:H:i:s',
                    'end_time' => 'required|date_format:H:i:s|after:start_time',
                    'extra_fee' => 'required|integer|min:0',
                ];
            case 'PUT': // Rules for updating an existing time slot
                return [
                    'slot_name' => 'required|string|max:255|unique:time_slots,slot_name,' . $this->route('timeSlot')->id,
                    'start_time' => 'required|date_format:H:i:s',
                    'end_time' => 'required|date_format:H:i:s|after:start_time',
                    'extra_fee' => 'required|integer|min:0',
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
            'slot_name.required' => 'Slot name is required.',
            'slot_name.unique' => 'Slot name already exists.',
            'slot_name.max' => 'Slot name should not exceed 255 characters.',
            'start_time.required' => 'Start time is required.',
            'start_time.date_format' => 'Start time must be in the format HH:MM:SS.',
            'end_time.required' => 'End time is required.',
            'end_time.date_format' => 'End time must be in the format HH:MM:SS.',
            'end_time.after' => 'End time must be after the start time.',
            'extra_fee.required' => 'Extra fee is required.',
            'extra_fee.integer' => 'Extra fee must be an integer.',
            'extra_fee.min' => 'Extra fee must be at least 0.',
        ];
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param \Illuminate\Contracts\Validation\Validator $validator
     * @throws \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(response()->json([
            'statusCode' => Response::HTTP_UNPROCESSABLE_ENTITY,
            'message' => $errors,
        ], Response::HTTP_UNPROCESSABLE_ENTITY));
    }
}
