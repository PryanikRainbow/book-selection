<?php

namespace App\Repositories\Country;

use App\Models\Country;
use Illuminate\Database\Eloquent\Collection;

class CountryRepository implements CountryRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Country::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Country
    {
        return Country::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function byName(string $countryName): ?Country
    {
        return Country::where('name', $countryName)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Country
    {
        return Country::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Country $country): bool
    {
        return $country->save();
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Country::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Country::destroy($id);
    }
}
