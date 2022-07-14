<?php

namespace App\Repositories;

use App\Models\Book;
use App\Models\Session;
use App\Repositories\Interfaces\BookRepositoryInterface;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Throwable;

/**
 *
 */
class BookRepository implements BookRepositoryInterface
{
    /**
     * @var Book
     */
    public Book $model;

    /**
     * BookRepository constructor.
     * @param  Book  $book
     */
    public function __construct(Book $book)
    {
        $this->model = $book;
    }

    /**
     * @param array $data
     * @return bool
     * @throws Throwable
     */
    public function create(array $data){
        return $this->model->create([
            'name'=>$data['name'],
            'author'=>$data['author'],
            'isbn'=>$data['isbn'],
            'published_at'=>$data['published_at'],
        ]);
    }

    /**
     * @param int $bookId
     * @param bool $exceptionExpected
     * @return Session
     * @throws Throwable
     * @throws ModelNotFoundException
     */
    public function getById(int $bookId, bool $exceptionExpected=false){
        return $exceptionExpected ? $this->model->findOrFail($bookId) : $this->model->find($bookId);
    }
}
