<?php

namespace App\Repositories\Country;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

interface CountryRepositoryInterface
{
    /**
     * @return Collection
     */
    public function all(): Collection;

    /**
     * @param int $id
     *
     * @return Country|null
     */
    public function byId(int $id): ?Country;

    /**
     * @param string $countryName
     *
     * @return Country|null
     */
    public function byName(string $countryName): ?Country;

    /**
     * @param string $data
     *
     * @return Country|null
     */
    public function getOrGetNew(array $data): ?Country;

    /**
     * @param Country $country
     *
     * @return bool
     */
    public function store(Country $country): bool;

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
