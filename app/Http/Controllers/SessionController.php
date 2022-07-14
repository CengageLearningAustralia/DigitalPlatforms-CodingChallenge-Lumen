<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSessionRequest;
use App\Http\Resources\SessionResource;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Interfaces\SessionBookRepositoryInterface;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Response;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpKernel\Exception\UnprocessableEntityHttpException;
use Throwable;

class SessionController extends Controller
{

    /**
     * @var SessionRepositoryInterface
     */
    private SessionRepositoryInterface $repository;

    /**
     * @var BookRepositoryInterface
     */
    private BookRepositoryInterface $bookRepository;

    /**
     * @var SessionBookRepositoryInterface
     */
    private SessionBookRepositoryInterface $sessionBookRepository;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SessionRepositoryInterface     $repository,
                                BookRepositoryInterface        $bookRepository,
                                SessionBookRepositoryInterface $sessionBookRepository)
    {
        $this->repository = $repository;
        $this->bookRepository = $bookRepository;
        $this->sessionBookRepository = $sessionBookRepository;
    }

    public function index()
    {
        try {
            $filters = request()->query('filters', []);
            return SessionResource::collection($this->repository->getByUserId(request()->user()->id, ['books'], $filters)
                ->paginate());
        } catch (Throwable $e) {
            report($e);
            return response()->json(['errors' => ['Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR]);
        }

    }

    public function show(int $sessionId)
    {
        try {
            $session = $this->repository->getById($sessionId, true);
            throw_if(request()->user()->cannot('view', $session), UnauthorizedException::class, 'Unauthorized', Response::HTTP_FORBIDDEN);
            return (new SessionResource($session->loadMissing('books')))->jsonSerialize();
        } catch (ModelNotFoundException|UnauthorizedException $e) {
            return response()->json(['errors' => [$e->getMessage()]], $e->getCode());
        } catch (Throwable $e) {
            report($e);
            return response()->json(['errors' => ['Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function store(CreateSessionRequest $createSession)
    {
        try {
            $data = $createSession->validate(request());
            $this->repository->create($data);
            return response()->json('Session created.');
        } catch (Throwable $e) {
            report($e);
            return response()->json(['errors' => ['Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

    public function assignBook(int $sessionId, int $bookId)
    {
        try {
            throw_if($this->sessionBookRepository->isSessionAndBookIdExists($sessionId, $bookId), UnprocessableEntityHttpException::class, 'Book already attached to the provided session');
            $this->repository->getById($sessionId, true);
            $this->bookRepository->getById($bookId, true);
            $this->sessionBookRepository->create($sessionId, $bookId);
            return response()->json('Book assigned to session successfully.');
        } catch (ModelNotFoundException $e) {
            return response()->json(['errors' => [$e->getMessage()]], Response::HTTP_NOT_FOUND);
        } catch (Throwable $e) {
            report($e);
            return response()->json(['errors' => ['Something went wrong.'], Response::HTTP_INTERNAL_SERVER_ERROR]);
        }
    }

}
