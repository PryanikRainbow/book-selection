<?php

namespace App\Providers;

use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\Format\FormatRepositoryInterface;
use App\Repositories\Genre\GenreRepositoryInterface;
use App\Repositories\Publisher\PublisherRepositoryInterface;
use App\Services\BookService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookService::class, function ($app) {
            return new BookService(
                $app->make(AuthorRepositoryInterface::class),
                $app->make(BookRepositoryInterface::class),
                $app->make(CountryRepositoryInterface::class),
                $app->make(FormatRepositoryInterface::class),
                $app->make(GenreRepositoryInterface::class),
                $app->make(PublisherRepositoryInterface::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
