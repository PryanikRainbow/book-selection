<?php

namespace App\Providers;

use App\Repositories\Author\AuthorRepository;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Book\BookRepository;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Country\CountryRepository;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\Format\FormatRepository;
use App\Repositories\Format\FormatRepositoryInterface;
use App\Repositories\Genre\GenreRepository;
use App\Repositories\Genre\GenreRepositoryInterface;
use App\Repositories\Publisher\PublisherRepository;
use App\Repositories\Publisher\PublisherRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->singleton(BookRepositoryInterface::class, BookRepository::class);
        $this->app->singleton(CountryRepositoryInterface::class, CountryRepository::class);
        $this->app->singleton(FormatRepositoryInterface::class, FormatRepository::class);
        $this->app->singleton(GenreRepositoryInterface::class, GenreRepository::class);
        $this->app->singleton(PublisherRepositoryInterface::class, PublisherRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
