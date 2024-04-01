<?php

namespace App\Repositories\Book;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;

class BookRepository implements BookRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Book::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Book
    {
        return Book::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Book $book): bool
    {
        return $book->save();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Book
    {
        return Book::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Book::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        $book = Book::find($id);
        $book->authors()->detach();
        $book->genres()->detach();

        return $book->delete();
    }
}
