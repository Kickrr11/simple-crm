<?php

namespace App\Services\Accounts;

use App\Services\Accounts\Contracts\CrudInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;
use App\Models\Account;
use Throwable;

/**
 * Class StoreOrUpdate
 * @package App\Services\Accounts
 */

class Crud implements CrudInterface
{
    /**
     * Returns all accounts
     * @return LengthAwarePaginator
     * @throws \Exception
     */
    public function all(): LengthAwarePaginator
    {
        try {
            return Account::paginate(10);
        } catch (Throwable $throwable) {
            throw new \Exception($throwable->getMessage());
        }
    }

    /**
     * Returns a single account
     * @param int $id
     * @return Model
     * @throws \Exception
     */

    public function show(int $id): Model
    {
        try {
            return Account::with("contacts")->findOrFail($id);
        } catch (Throwable $throwable) {
            throw new \Exception($throwable->getMessage());
        }
    }

    /**
     * Store or updates an account
     * @param array $data
     * @param int $id
     * @return Model
     * @throws \Exception
     */

    public function storeOrUpdate(array $data, $id = null): Model
    {
        $account = $id ? Account::findOrFail($id) : new Account();
        $account->fill($data);
        $account->user()->associate($data["user_id"]);
        $account->save();
        return $account;
    }

    /**
     * Deletes a single account
     * @param int $id
     * @throws \Exception
     */

    public function delete(int $id): void
    {
        try {
            $account = Account::findOrFail($id);
            $account->delete();
        } catch (Throwable $throwable) {
            throw new \Exception($throwable->getMessage());
        }
    }
}
