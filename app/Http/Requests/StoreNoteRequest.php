<?php

namespace App\Http\Requests;

use App\Rules\NotesMorphRule;
use Illuminate\Foundation\Http\FormRequest;
use Arr;
use JetBrains\PhpStorm\ArrayShape;

class StoreNoteRequest extends FormRequest
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
    #[ArrayShape(["body" => "string", 'noteable_type' => "string", 'noteable_id' => "string", "noteable_type" => "\App\Rules\NotesMorphRule"])]
    public function rules(): array
    {
        $rules = [
            "body" => "required|min:2",
            'noteable_type' => 'required|string',
            'noteable_id' => 'required|integer',
        ];
        $request = request()->all();

        if (Arr::get($request, "noteable_type") && Arr::get($request, "noteable_id")) {
            $rules["noteable_type"] = new NotesMorphRule(Arr::get($request, "noteable_id"));
        }
        return $rules;
    }
}
