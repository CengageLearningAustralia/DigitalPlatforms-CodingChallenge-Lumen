<?php

namespace App\Repositories;

use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Carbon;
use Throwable;

/**
 *
 */
class SessionRepository implements SessionRepositoryInterface
{
    /**
     * @var Session
     */
    public Session $model;

    /**
     * SessionRepository constructor.
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->model = $session;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function create(array $data)
    {
        return $this->model->create([
            'user_id' => $data['user_id'],
            'name' => $data['name'],
            'start_at' => $data['start_at'],
        ]);
    }

    /**
     * @param int $sessionId
     * @param bool $exceptionExpected
     * @return Session
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function getById(int $sessionId, bool $exceptionExpected = false)
    {
        return $exceptionExpected ? $this->model->findOrFail($sessionId) : $this->model->find($sessionId);
    }

    /**
     * @param int $userId
     * @param array $with
     * @param array $filters
     * @return Builder
     * @throws Throwable
     */
    public function getByUserId(int $userId, array $with = [], array $filters = [])
    {
        $builder = $this->model->where('user_id', $userId);
        if (!empty($filters['includePastSessions']) && $filters['includePastSessions'] !== "true") {
            $builder->where('start_at', '>=', Carbon::now());
        }
        return $builder->with($with)
            ->orderBy('start_at');
    }
}
