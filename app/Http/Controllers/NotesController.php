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
     * Returns all accounts.
     *
     * @return Response
     * @throws Throwable
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
     * Creates a new note.
     * @param StoreNoteRequest $storeNoteRequest
     * @return Response
     * @throws Throwable
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
            dd($throwable->getMessage());
            return ResponseBuilder::error($throwable->getCode(), ["notes" => $throwable->getMessage()], $throwable->getMessage(), $throwable->getCode());
        }
    }
}
