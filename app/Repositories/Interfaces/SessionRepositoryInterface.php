<?php

namespace App\Repositories\Interfaces;

use App\Models\Session;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface SessionRepositoryInterface
{
    /**
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function create(array $data);

    /**
     * @param int $sessionId
     * @param bool $exceptionExpected
     * @return Session
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function getById(int $sessionId, bool $exceptionExpected = false);

    /**
     * @param int $userId
     * @param array $with
     * @param array $filters
     * @return Builder
     * @throws Throwable
     */
    public function getByUserId(int $userId, array $with = [], array $filters = []);
}
