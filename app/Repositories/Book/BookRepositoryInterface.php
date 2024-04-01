<?php

namespace App\Repositories\Book;

use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;


interface BookRepositoryInterface
{
    /**
     * @return array
     */
    public function all();

    /**
     * @param int $id
     *
     * @return Book|null
     */
    public function byId(int $id): ?Book;

    /**
     * @param Book $book
     *
     * @return bool
     */
    public function store(Book $book): bool;

    /**
     * @param string $data
     *
     * @return Book|null
     */
    public function getOrGetNew(array $data): ?Book;

    /**
     * @param int   $id
     * @param array $data
     *
     * @return bool
     */
    public function update(int $id, array $data): bool;

    /**
     * @param int $id
     *
     * @return bool
     */
    public function delete(int $id): bool;
}
