<?php

namespace App\Repositories\Interfaces;

use App\Models\Session;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

interface BookRepositoryInterface
{
    /**
     * To create book model record
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function create(array $data);

    /**
     * To return book model record by id
     * @param int $bookId
     * @param bool $exceptionExpected
     * @return Session
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function getById(int $bookId, bool $exceptionExpected=false);
}
