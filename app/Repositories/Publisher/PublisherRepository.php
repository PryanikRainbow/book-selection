<?php

namespace App\Repositories\Publisher;

use App\Models\Publisher;
use Illuminate\Database\Eloquent\Collection;

class PublisherRepository implements PublisherRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Publisher::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Publisher
    {
        return Publisher::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function byName(string $name): ?Publisher
    {
        return Publisher::where('name', $name)->first();
    }

        /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Publisher
    {
        return Publisher::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Publisher $publisher): bool
    {
        return $publisher->save();
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Publisher::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Publisher::destroy($id);
    }
}
