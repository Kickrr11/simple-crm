<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNoteRequest;
use App\Models\Note;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use MarcinOrlowski\ResponseBuilder\ResponseBuilder;
use Spatie\RouteAttributes\Attributes\Middleware;
use Spatie\RouteAttributes\Attributes\Prefix;
use Spatie\RouteAttributes\Attributes\Resource;
use Symfony\Component\HttpFoundation\Response;
use Throwable;
use App\Services\Notes\Contracts\CrudInterface;


/**
 * Class NotesController
 * @package App\Http\Controllers
 */
#[Middleware('auth:api')]
#[Prefix('api')]
#[Resource('notes', except: ['create', 'edit'], names: 'api.notes')]

class NotesController extends Controller
{
    /**
     * NotesController constructor.
     * @param  CrudInterface $crudService
     */

    public function __construct(private CrudInterface $crudService){}

    /**
     * Notes returns all .
     *
     * @return Response
     * @throws Throwable
     * @responseFile storage/responses/notes/get.json
     */

    public function index(): Response
    {
        try {
            return ResponseBuilder::success(['notes' => $this->crudService->all()], 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["notes" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Note Shows single .
     *
     * @param int $id
     * @return Response
     * @throws Exception
     * @responseFile storage/responses/notes/show_single.json
     */

    public function show(int $id): Response
    {
        try {
            return ResponseBuilder::success(["notes" => $this->crudService->show($id)], 200);
        } catch (Throwable $throwable) {
            return ResponseBuilder::error($throwable->getCode(), ["notes" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }

    /**
     * Note creates a new .
     * @param StoreNoteRequest $storeNoteRequest
     * @return Response
     * @throws Throwable
     * @responseFile storage/responses/notes/created.json
     */

    public function store(StoreNoteRequest $storeNoteRequest): Response
    {
        try {
            DB::beginTransaction();
            $note = $this->crudService->storeOrUpdate($storeNoteRequest->validated());
            DB::commit();
            return ResponseBuilder::success(["note" => $note], 201, [], 201);
        } catch (Throwable $throwable) {
            DB::rollBack();
            return ResponseBuilder::error($throwable->getCode(), ["notes" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }
}
