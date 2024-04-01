<?php

namespace App\Repositories\Author;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

/**
 * @TODO delete extra methods
 */
interface AuthorRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return Author|null
     */
    public function byId(int $id): ?Author;

    /**
     * @param string $name
     *
     * @return Author|null
     */
    public function byName(string $name): ?Author;

    /**
     * @param string $data
     *
     * @return Author|null
     */
    public function getOrGetNew(array $data): ?Author;

    /**
     * @param Author $author
     *
     * @return bool
     */
    public function store(Author $author): bool;

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
