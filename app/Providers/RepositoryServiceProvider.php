<?php

namespace App\Providers;

use App\Repositories\BookRepository;
use App\Repositories\Interfaces\BookRepositoryInterface;
use App\Repositories\Interfaces\SessionBookRepositoryInterface;
use App\Repositories\Interfaces\SessionRepositoryInterface;
use App\Repositories\SessionBookRepository;
use App\Repositories\SessionRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     * Sort in alphabetical order
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(SessionRepositoryInterface::class, SessionRepository::class);
        $this->app->bind(SessionBookRepositoryInterface::class, SessionBookRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot()
    {
    }
}
