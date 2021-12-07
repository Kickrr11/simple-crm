<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Database\Eloquent\Relations\Relation;

class NotesMorphRule implements Rule
{

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(private string $noteableId) {}

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        try {
            $relatedModel = Relation::getMorphedModel($value);
            $model = resolve($relatedModel)
                ->find($this->noteableId);
            if (!$model) {
                return false;
            }
            return true;
        } catch (\Throwable $throwable) {
            return false;
        }
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'Relation or record doesnt exist.';
    }
}
