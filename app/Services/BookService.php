<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Book;
use App\Models\Country;
use App\Models\Format;
use App\Models\Publisher;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookService
{
    /**
     * BookService constructor.
     *
     * @param BookAuthorService $bookAuthorService
     * @param BookGenreService  $bookAuthorService
     */
    public function __construct(
        private BookAuthorService $bookAuthorService,
        private BookGenreService  $bookGenreService,
    ) {}

    /**
     * @param array $input
     * 
     * @return LengthAwarePaginator
     */
    public function getList(array $input): LengthAwarePaginator
    {
        try {
            $query = Book::query()
                ->select(['id', 'title', 'release_date', 'publisher_id'])
                ->with([
                    'authors:id,name',
                    'publisher:id,name',
                ]);

            $perPage = $input['per_page'] ?? $query->count();

            return $query->paginate($perPage);
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to get book list failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $input,
                ]
            );

            throw new AppException('Something went wrong: Attempt to get book list failed');
        }
    }

    /**
     * @param array $data
     *
     * @return Book
     */
    public function create(array $data): Book
    {
        try {
            DB::beginTransaction();

            $countryId   = Country::firstOrCreate(['name' => $data['country']])->id;
            $publisherId = Publisher::firstOrCreate(['name' => $data['publisher']])->id;
            $formatId    = Format::firstOrCreate(['name' => $data['format']])->id;
            $edition     = isset($data['edition']) && is_numeric($data['edition']) ? $data['edition'] : null;

            /** @var Book $book */
            $book        = Book::create(
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

            $this->bookAuthorService->syncAuthors($book, $data['authors']);
            $this->bookGenreService->syncGenres($book, $data['genres']);

            DB::commit();

            return $book;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to create book failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $data,
                ]
            );

            throw new AppException('Something went wrong: Attempt to create book failed');
        }
    }

    /**
     * @param Book  $book
     * @param array $data
     *
     * @return Book
     */
    public function update(Book $book, array $data): Book
    {
        try {
            DB::beginTransaction();

            $countryId   = Country::firstOrCreate(['name' => $data['country']])->id;
            $publisherId = Publisher::firstOrCreate(['name' => $data['publisher']])->id;
            $formatId    = Format::firstOrCreate(['name' => $data['format']])->id;
            $edition     = isset($data['edition']) && is_numeric($data['edition']) ? $data['edition'] : null;

            $book->update(
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

            $this->bookAuthorService->syncAuthors($book, $data['authors']);
            $this->bookGenreService->syncGenres($book, $data['genres']);

            DB::commit();

            return $book;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to update book failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $data,
                ]
            );

            throw new AppException('Something went wrong: Attempt to update book failed');
        }


        return $book;
    }

    /**
     * @param Book $book
     * 
     * @return void
     */
    public function delete(Book $book): void
    {
        try {
            DB::beginTransaction();

            $book->authors()->detach();
            $book->genres()->detach();

            $book->delete();

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to delete book failed',
                [
                    'message' => $e->getMessage(),
                    'book_id' => $book->id,
                ]
            );

            throw new AppException('Something went wrong: Attempt to delete book failed');
        }
    }

    /**
     * @param array $data
     *
     * @return Book
     */
    public function getOrCreate(array $data): Book
    {
        try {
            DB::beginTransaction();

            $countryId   = Country::firstOrCreate(['name' => $data['country']])->id;
            $publisherId = Publisher::firstOrCreate(['name' => $data['publisher']])->id;
            $formatId    = Format::firstOrCreate(['name' => $data['format']])->id;
            $edition     = isset($data['edition']) && is_numeric($data['edition']) ? $data['edition'] : null;

            $book        = Book::firstOrCreate(
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

            $this->bookAuthorService->syncAuthors($book, $data['authors']);
            $this->bookGenreService->syncGenres($book, $data['genres']);

            DB::commit();

            return $book;
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to get/create book failed',
                [
                    'message'   => $e->getMessage(),
                    'data_book' => $data,
                ]
            );

            throw new AppException('Something went wrong: Attempt to get/create book failed');
        }
    }
}
