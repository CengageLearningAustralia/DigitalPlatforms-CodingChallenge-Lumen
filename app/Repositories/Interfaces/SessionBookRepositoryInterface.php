<?php

namespace App\Repositories\Interfaces;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface SessionBookRepositoryInterface
{
    /**
     * @param int $sessionId
     * @param int $bookId
     * @return bool
     * @throws Throwable
     */
    public function create(int $sessionId, int $bookId);

    /**
     * @param int $sessionId
     * @param int $bookId
     * @return bool
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function isSessionAndBookIdExists(int $sessionId, int $bookId);
}
