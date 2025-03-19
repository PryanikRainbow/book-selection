<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Author;
use App\Models\Book;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class BookAuthorService
{
    /**
     * BookAuthorService constructor.
     *
     * @param AuthorService $authorService
     */
    public function __construct(
        private AuthorService $authorService,
    ) {}

    /**
     * @param Book $book
     * @param array $authors
     *
     * @return void
     */
    public function syncAuthors(Book $book, array $authors): void
    {
        try {
            DB::beginTransaction();

            $authorIds = $this->prepareAuthorIds($authors);
            $book->authors()->sync($authorIds);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();

            Log::error(
                'Something went wrong: Attempt to get sync authors failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $authors,
                    'book_id' => $book->id,
                ]
            );

            throw new AppException('Something went wrong: Attempt to sync authors failed');
        }
    }

    /**
     * @param array $authors
     *
     * @return array
     */
    private function prepareAuthorIds(array $authors): array
    {
        $authorIds = [];

        foreach ($authors as $authorName) {
            $author = Author::where('name', $authorName)->first();

            if (!$author) {
                $author = $this->authorService->create(['name' => $authorName]);
            }

            $authorIds[] = $author->id;
        }

        return $authorIds;
    }
}
