<?php

namespace App\Services\Contacts\Contracts;

use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Model;

interface CrudInterface
{
    /**
     * @return LengthAwarePaginator
     */
    public function all() : LengthAwarePaginator;

    /**
     * @param int $id
     * @return Model
     */
    public function show(int $id) : Model;

    /**
     * @param array $data
     * @param null $id
     * @return Model
     */
    public function storeOrUpdate(array $data, $id = null) : Model;

    /**
     * @param int $id
     */
    public function delete(int $id) : void;
}
