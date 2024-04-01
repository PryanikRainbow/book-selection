<?php

namespace App\Repositories\Genre;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

interface GenreRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return Genre|null
     */
    public function byId(int $id): ?Genre;

    /**
     * @param string $name
     *
     * @return Genre|null
     */
    public function byName(string $name): ?Genre;

        /**
     * @param string $data
     *
     * @return Genre|null
     */
    public function getOrGetNew(array $data): ?Genre;
    /**
     * @param Genre $genre
     *
     * @return bool
     */
    public function store(Genre $genre): bool;

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
