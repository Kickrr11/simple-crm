<?php


namespace App\Services\Notes;

use App\Models\Account;
use App\Models\Note;
use App\Services\Notes\Contracts\CrudInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Arr;
use Illuminate\Database\Eloquent\Relations\Relation;

class Crud implements CrudInterface
{
    /**
     * Returns all notes
     * @return LengthAwarePaginator
     * @throws Exception
     */

    public function all(): LengthAwarePaginator
    {
        try {
            return Note::with("account")->with("contact")->paginate(10);
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }
    }

    public function show(int $id): Model
    {
        return Note::with("noteable")->findOrFail($id);
    }

    /**
     * Stores or updates a note
     * @param array $data
     * @param null $id
     * @return Model
     * @throws Exception
     */

    public function storeOrUpdate(array $data, $id = null): Model
    {
        try {
            $note = $id ? Note::findOrFail($id) : new Note();
            $note->body = Arr::get($data, "body");
            $relatedModel = Relation::getMorphedModel($data["noteable_type"]);
            $theRelatedModel = resolve($relatedModel)
                ->find($data["noteable_id"]);
            $note->noteable()->associate($theRelatedModel);
            return $note;
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }

    }

    public function delete(int $id): void
    {
        // TODO: Implement delete() method.
    }
}

