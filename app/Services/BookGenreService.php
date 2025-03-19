<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Genre;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookGenreService
{
    /**
     * BookGenreService constructor.
     *
     * @param GenreService $genreService
     */
    public function __construct(
        private GenreService $genreService,
    ) {}

    /**
     * @param Book $book
     * @param array $genres
     *
     * @return void
     */
    public function syncGenres(Book $book, array $genres): void
    {
        try {
            DB::beginTransaction();

            $genreIds = $this->prepareGenreIds($genres);
            $book->genres()->sync($genreIds);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to get sync genres failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $genres,
                    'book_id' => $book->id,
                ]
            );

            throw new AppException('Something went wrong: Attempt to sync genres failed');
        }
    }

    /**
     * @param array $genres
     *
     * @return array
     */
    private function prepareGenreIds(array $genres): array
    {
        $genreIds = [];

        foreach ($genres as $genreName) {
            $genre = Genre::where('name', $genreName)->first();

            if (!$genre) {
                $genre = $this->genreService->create(['name' => $genreName]);
            }

            $genreIds[] = $genre->id;
        }

        return $genreIds;
    }
}
