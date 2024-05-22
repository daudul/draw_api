<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class RegisterRequest extends FormRequest
{
    use ApiResponse;
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ];
    }

    /**
     * Override the function
     * @param Validator $validator
     * @return mixed
     */
    public function failedValidation(Validator $validator): mixed
    {
        throw new HttpResponseException(
            self::validatedError(message: $validator->errors()->toArray(),
            httpStatusCode: Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
