<?php

namespace App\Repositories\Author;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;

class AuthorRepository implements AuthorRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Author::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Author
    {
        return Author::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function byName(string $name): ?Author
    {
        return Author::where('name', $name)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Author
    {
        return Author::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Author $author): bool
    {
        return $author->save();
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Author::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Author::destroy($id);
    }
}
