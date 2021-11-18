<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
    public function rules(): array
    {
        return [
            "first_name" => "required|min:2",
            "last_name" => "required|min:2",
            "job_title" => "sometimes|min:2",
            "account_id" => "required|integer",
            "postal_code" => "sometimes|min:2",
            "city" => "sometimes|min:2",
            "address" => "sometimes|min:2",
            "email" => "sometimes|email",
            //"phone" => "sometimes|required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10",
            "country_code" => "sometimes:exists:countries.code",
        ];
    }
}
