<?php

namespace App\Repositories\Genre;

use App\Models\Genre;
use Illuminate\Database\Eloquent\Collection;

class GenreRepository implements GenreRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Genre::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Genre
    {
        return Genre::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function byName(string $name): ?Genre
    {
        return Genre::where('name', $name)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Genre
    {
        return Genre::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Genre $genre): bool
    {
        return $genre->save();
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Genre::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Genre::destroy($id);
    }
}
