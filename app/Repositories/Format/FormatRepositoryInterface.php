<?php

namespace App\Repositories\Format;

use App\Models\Format;
use Illuminate\Database\Eloquent\Collection;

interface FormatRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return Format|null
     */
    public function byId(int $id): ?Format;

    /**
     * @param string $formatName
     *
     * @return Format|null
     */
    public function byName(string $formatName): ?Format;

    /**
     * @param string $data
     *
     * @return Format|null
     */
    public function getOrGetNew(array $data): ?Format;

    /**
     * @param Format $format
     *
     * @return bool
     */
    public function store(Format $format): bool;

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
