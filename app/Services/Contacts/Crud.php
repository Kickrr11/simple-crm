<?php

namespace App\Services\Contacts;

use App\Models\Contact;
use App\Services\Contacts\Contracts\CrudInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use Arr;

class Crud implements CrudInterface
{
    /**
     * Returns all contacts
     * @return LengthAwarePaginator
     * @throws Exception
     */

    public function all(): LengthAwarePaginator
    {
        try {
            return Contact::with("account")->paginate(10);
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }
    }

    /**
     * Returns a single contact
     * @param int $id
     * @return Model
     * @throws Exception
     */

    public function show(int $id): Model
    {
        try {
            return Contact::with("account")->findOrFail($id);
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }
    }

    /**
     * Stores or updates a contact
     * @param array $data
     * @param null $id
     * @return Model
     * @throws Exception
     */
    public function storeOrUpdate(array $data, $id = null): Model
    {
        try {
            $contact = $id  ?  Contact::findOrFail($id) : new Contact();
            $contact->account()->associate(Arr::get($data, 'account_id'));
            $contact->fill($data);
            $contact->save();
            return $contact;
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }
    }

    /**
     * Deletes a contact
     * @param int $id
     * @throws Exception
     */

    public function delete(int $id): void
    {
        try {
            $account = Contact::findOrFail($id);
            $account->delete();
        } catch (\Throwable $throwable) {
            throw new Exception($throwable->getMessage());
        }

    }
}
