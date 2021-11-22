<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreContactRequest;
use App\Services\Contacts\Contracts\CrudInterface;
use Exception;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\Exceptions\ArrayWithMixedKeysException;
use MarcinOrlowski\ResponseBuilder\Exceptions\ConfigurationNotFoundException;
use MarcinOrlowski\ResponseBuilder\Exceptions\IncompatibleTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\InvalidTypeException;
use MarcinOrlowski\ResponseBuilder\Exceptions\MissingConfigurationKeyException;
use MarcinOrlowski\ResponseBuilder\Exceptions\NotIntegerException;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;
use Symfony\Component\HttpFoundation\Response;
use Arr;
use Throwable;

/**
 * Class ContactsController
 * @package App\Http\Controllers
 */

#[Prefix('api')]
#[Middleware('auth:api')]
#[Resource('contacts', except: ['create', 'edit'], names: 'api.contacts')]

class ContactsController extends Controller
{
    /**
     * ContactsController constructor.
     * @param CrudInterface $crudService
     */
    public function __construct(private CrudInterface $crudService){}

    /**
     * Contacts Returns all.
     * @return Response
     * @responseFile storage/responses/contacts/get.json
     * @throws Throwable
     */

    public function index(): Response
    {
        try {
            return ResponseBuilder::success(['contacts' => $this->crudService->all()], 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["contacts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Contacts Stores newly created.
     * @param StoreContactRequest $storeContactRequest
     * @return Response
     * @throws Exception|Throwable
     * @responseFile storage/responses/contacts/created.json
     */
    public function store(StoreContactRequest $storeContactRequest): Response
    {
        try {
            DB::beginTransaction();
            $contact = $this->crudService->storeOrUpdate($storeContactRequest->validated());
            DB::commit();
            return ResponseBuilder::success(["contact" => $contact], 201);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["contacts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }


    /**
     * Contact Shows single .
     *
     * @param int $id
     * @return Response
     * @throws Exception
     * @responseFile storage/responses/contacts/show_single.json
     */
    public function show(int $id): Response
    {
        try {
            return ResponseBuilder::success(["contact" => $this->crudService->show($id)], 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["contacts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Contact Updates an existing.
     * @param StoreContactRequest $storeContactRequest
     * @param $id
     * @return Response
     * @throws Throwable
     * @throws ArrayWithMixedKeysException
     * @throws ConfigurationNotFoundException
     * @throws IncompatibleTypeException
     * @throws InvalidTypeException
     * @throws MissingConfigurationKeyException
     * @throws NotIntegerException
     * @responseFile storage/responses/contacts/updated.json
     */

    public function update(StoreContactRequest $storeContactRequest, $id): Response
    {
        try {
            DB::beginTransaction();
            $contact = $this->crudService->storeOrUpdate($storeContactRequest->validated(), $id);
            DB::commit();
            return ResponseBuilder::success(["contact" => $contact], 200);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["contacts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     *  Contact Deletes an existing.
     * @param $id
     * @return Response
     * @throws Exception|Throwable
     * @responseFile storage/responses/contacts/deleted.json
     */

    public function destroy($id): Response
    {
        try {
            DB::beginTransaction();
            $this->crudService->delete($id);
            DB::commit();
            return ResponseBuilder::success("Contact successfully deleted", 200);
        } catch (\Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["contacts" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }
}
