<?php

namespace App\Http\Controllers;

use App\Services\Accounts\Contracts\CrudInterface;
use Exception;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use App\Http\Requests\StoreAccountRequest;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use Spatie\RouteAttributes\Attributes\Resource;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Arr;

/**
 * Class AccountsController
 * @package App\Http\Controllers
 */

#[Prefix('api')]
#[Middleware('auth:api')]
#[Resource('accounts', except: ['create', 'edit'], names: 'api.accounts')]

class AccountsController extends Controller
{
    /**
     * AccountsController constructor.
     * @param CrudInterface $crudService
     */

    public function __construct(
        private CrudInterface $crudService
    ){}

    /**
     * Returns all accounts.
     *
     * @return Response
     * @throws Exception
     */
    public function index(): Response
    {
        try {
            $data = ['accounts' => $this->crudService->all()];
            return ResponseBuilder::success($data, 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["accounts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Stores newly created account.
     * @param StoreAccountRequest $accountRequest
     * @return Response
     * @throws Exception|Throwable
     */
    public function store(StoreAccountRequest $accountRequest): Response
    {
        try {
            DB::beginTransaction();
            $account = $this->crudService->storeOrUpdate($accountRequest->validated());
            DB::commit();
            return ResponseBuilder::success(["account" => $account], 201, null, 201);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["accounts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Shows single account.
     * @param int $id
     * @return Response
     * @throws Exception
     */

    public function show(int $id): Response
    {
        try {
            $account = $this->crudService->show($id);
            return ResponseBuilder::success(["account" => $account], 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["accounts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Updates an existing account.
     * @param StoreAccountRequest $accountRequest
     * @param $id
     * @return Response
     * @throws Throwable
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     */

    public function update(StoreAccountRequest $accountRequest, $id): Response
    {
        try {
            DB::beginTransaction();
            $account = $this->crudService->storeOrUpdate($accountRequest->validated(), $id);
            DB::commit();
            return ResponseBuilder::success(["account" => $account], 200);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["accounts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Deletes an existing account.
     * @param $id
     * @return Response
     * @throws Exception|Throwable
     */

    public function destroy($id): Response
    {
        try {
            DB::beginTransaction();
            $this->crudService->delete($id);
            DB::commit();
            return ResponseBuilder::success("Account successfully deleted", 200);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["accounts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }
}
