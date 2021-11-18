<?php

namespace App\Http\Requests;

use App\Rules\NotesMorphRule;
use Illuminate\Foundation\Http\FormRequest;
use Arr;

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
    public function rules()
    {
        $rules = [
            "body" => "required|min:2",
            'noteable_type' => 'required|string',
            'noteable_id' => 'required|integer',
        ];
        $request = request()->all();
        $noteableType = Arr::get($request, "noteable_type");
        $noteableId = Arr::get($request, "noteable_id");
        if ($noteableType AND $noteableId) {
            $rules["noteable_type"] = new NotesMorphRule($noteableType, $noteableId);
        }
        return $rules;
    }
}
