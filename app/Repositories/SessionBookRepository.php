<?php

namespace App\Repositories;

use App\Models\SessionBook;
use App\Repositories\Interfaces\SessionBookRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 *
 */
class SessionBookRepository implements SessionBookRepositoryInterface
{
    /**
     * @var SessionBook
     */
    public SessionBook $model;

    /**
     * SessionBookRepository constructor.
     * @param SessionBook $sessionBook
     */
    public function __construct(SessionBook $sessionBook)
    {
        $this->model = $sessionBook;
    }

    /**
     * @param int $sessionId
     * @param int $bookId
     * @return bool
     * @throws Throwable
     */
    public function create(int $sessionId, int $bookId)
    {
        return $this->model->create([
            'session_id' => $sessionId,
            'book_id' => $bookId,
        ]);
    }

    /**
     * @param int $sessionId
     * @param int $bookId
     * @return bool
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function isSessionAndBookIdExists(int $sessionId, int $bookId)
    {
        return $this->model->where(['session_id' => $sessionId, 'book_id' => $bookId])->exists();
    }
}
