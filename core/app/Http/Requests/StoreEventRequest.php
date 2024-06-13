<?php

namespace App\Http\Requests;

use App\Traits\ApiResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rules\File;

class StoreEventRequest extends FormRequest
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
            'name' => 'required',
            'event_type' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'image_url' => File::types($this->acceptImageType())->max(5 * 1024),
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

    protected function acceptImageType():array
    {
        return[
            'jpeg', 'png', 'jpg', 'gif', 'svg'
        ];
    }
}
