<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use JetBrains\PhpStorm\ArrayShape;

class StoreAccountRequest extends FormRequest
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
     * @return array
     */
    #[ArrayShape(["name" => "string", "description" => "string", "address" => "string", "postal_code" => "string", "city" => "string", "is_active" => "string", "country_code" => "string", "user_id" => "integer"])]
    public function rules(): array
    {
        return [
            "name" => "required|min:2",
            "description" => "sometimes|min:2",
            "address" => "sometimes|min:2",
            "postal_code" => "sometimes|min:2",
            "city" => "sometimes|min:2",
            "is_active" => "required:boolean",
            "country_code" => "sometimes:exists:countries.code",
            "user_id" => "required|integer"
        ];
    }
}
