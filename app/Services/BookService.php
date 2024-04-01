<?php

namespace App\Services;

use App\Repositories\Author\AuthorRepositoryInterface;
use App\Repositories\Book\BookRepositoryInterface;
use App\Repositories\Country\CountryRepositoryInterface;
use App\Repositories\Format\FormatRepositoryInterface;
use App\Repositories\Genre\GenreRepositoryInterface;
use App\Repositories\Publisher\PublisherRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Exception;

class BookService
{

    /**
     * BookService constructor.
     *
     * @param AuthorRepositoryInterface    $authorRepository
     * @param BookRepositoryInterface      $bookRepository
     * @param CountryRepositoryInterface   $countryRepository
     * @param FormatRepositoryInterface    $formatRepository
     * @param GenreRepositoryInterface     $genreRepository
     * @param PublisherRepositoryInterface $publisherRepository
     */
    public function __construct(
        private AuthorRepositoryInterface    $authorRepository,
        private BookRepositoryInterface      $bookRepository,
        private CountryRepositoryInterface   $countryRepository,
        private FormatRepositoryInterface    $formatRepository,
        private GenreRepositoryInterface     $genreRepository,
        private PublisherRepositoryInterface $publisherRepository,
    ) {
    }

    /**
     * @return array
     */
    public function booksListInfo(): array
    {
        return $this->bookRepository->all()->map(function ($book) {
            return [
                'title' => $book->title,
                'year' => date('Y', strtotime($book->release_date)),
                'authors' => $book->authors->pluck('name')->toArray(),
                'publisher' => $book->publisher->name,
            ];
        })->toArray();
    }

    /**
     * @param int $id
     *
     * @return array|null
     */
    public function bookInfo(int $id): array|null
    {
        $book = $this->bookRepository->byId($id);

        if ($book) {
            return [
                'id'           => $id,
                'title'        => $book->title,
                'authors'      => $book->authors->pluck('name')->toArray(),
                'genres'       => $book->genres->pluck('name')->toArray(),
                'description'  => $book->description,
                'edition'      => $book->edition,
                'release_date' => date($book->release_date),
                'publisher'    => $book->publisher->name,
                'format'       => $book->format->format,
                'pages'        => $book->pages,
                'country'      => $book->country->country_name,
                'ISBN'         => $book->ISBN
            ];
        }

        return null;
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function createOrUpdate(array $data): void
    {
        try {
            DB::beginTransaction();
            $this->bookInsertOrUpdate($data);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());;
        }
    }

    /**
     * @return void
     */
    public function deleteBook(int $id): void
    {
        $this->bookRepository->delete($id);
    }

    /**
     * @param array $data
     *
     * @return void
     */
    public function bookInsertOrUpdate($data): void
    {       
        $authorsIds  = $this->addAuthors($data['authors']);
        $genreIds    = $this->addGenres($data['genres']);
        $countryId   = $this->countryRepository->getOrGetNew(['country_name' => $data['country']])->id;
        $publisherId = $this->publisherRepository->getOrGetNew(['name' => $data['publisher']])->id;
        $formatId    = $this->formatRepository->getOrGetNew(['format' => $data['format']])->id;
        $edition     = is_numeric($data['edition']) ? $data['edition'] : null;

        $book        = $this->bookRepository->getOrGetNew(
            [
                'title'        => $data['title'],
                'description'  => $data['description'],
                'edition'      => $edition,
                'publisher_id' => $publisherId,
                'release_date' => $data['release_date'],
                'format_id'    => $formatId,
                'pages'        => $data['pages'],
                'country_id'   => $countryId,
                'ISBN'         => $data['ISBN'],
            ]
        );
        $book->authors()->sync($authorsIds);
        $book->genres()->sync($genreIds);
    }

    /**
     * @param array $authors
     *
     * @return array
     */
    private function addAuthors(array $authors): array
    {
        $authorIds = [];

        foreach ($authors as $authorName) {
            $authorIds[] = $this->authorRepository->getOrGetNew(['name' => $authorName])->id;
        }

        return $authorIds;
    }

    /**
     * @param array $genres
     *
     * @return array
     */
    private function addGenres(array $genres): array
    {
        $genreIds = [];

        foreach ($genres as $genre) {
            $genreIds[] = $this->genreRepository->getOrGetNew(['name' => $genre])->id;
        }

        return $genreIds;
    }
}
