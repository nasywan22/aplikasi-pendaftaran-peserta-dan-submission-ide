<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateFormRequest extends FormRequest
{
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
            "name"=> "nullable|string",
            "telepon"=> "nullable|string|max:15",
            "email"=> "required|email",
            "password"=> "required",
            "g-recaptcha-response"=> "required",
            "rememberMe"=> "sometimes|boolean",
        ];
    }
}
