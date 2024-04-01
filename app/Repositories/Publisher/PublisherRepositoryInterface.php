<?php

namespace App\Repositories\Publisher;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Collection;

interface PublisherRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return Publisher|null
     */
    public function byId(int $id): ?Publisher;

    /**
     * @param string $name
     *
     * @return Publisher|null
     */
    public function byName(string $name): ?Publisher;

        /**
     * @param string $data
     *
     * @return Publisher|null
     */
    public function getOrGetNew(array $data): ?Publisher;

    /**
     * @param Publisher $publisher
     *
     * @return bool
     */
    public function store(Publisher $publisher): bool;

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
