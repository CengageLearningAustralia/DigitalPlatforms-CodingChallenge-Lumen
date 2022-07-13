<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Session;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
     * @param  Session  $session
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
    public function create($data){
        return $this->model->create([
            'user_id'=>$data['user_id'],
            'name'=>$data['name'],
            'start_at'=>$data['start_at'],
        ]);
    }

    /**
     * @param int $sessionId
     * @param bool $exceptionExpected
     * @return Session
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function getById(int $sessionId, bool $exceptionExpected=false){
        return $exceptionExpected ? $this->model->findOrFail($sessionId) : $this->model->find($sessionId);
    }

    /**
     * @param int $userId
     * @param array $with
     * @return Session
     * @throws Throwable
     */
    public function getByUserId(int $userId, array $with=[]){
        return $this->model->where('user_id',$userId)
            ->with($with)
            ->orderBy('start_at')
            ->paginate();
    }

    /**
     * @param Session $session
     * @param Book $book
     * @throws Throwable
     */
    public function assignBook(Session $session, Book $book){
        return $session->books()->attach($book->id);
    }
}
