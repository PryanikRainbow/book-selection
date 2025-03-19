<?php

namespace App\Providers;

use App\Models\BookAuthor;
use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\Format\FormatRepositoryInterface;
use App\Repositories\Genre\GenreRepositoryInterface;
use App\Repositories\Publisher\PublisherRepositoryInterface;
use App\Services\AuthorService;
use App\Services\BookAuthorService;
use App\Services\BookGenreService;
use App\Services\BookService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
