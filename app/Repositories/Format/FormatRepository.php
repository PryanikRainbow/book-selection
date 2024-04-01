<?php

namespace App\Repositories\Format;

use App\Models\Format;
use Illuminate\Database\Eloquent\Collection;

class FormatRepository implements FormatRepositoryInterface
{
    /**
     * {@inheritDoc}
     */
    public function all(): Collection
    {
        return Format::all();
    }

    /**
     * {@inheritDoc}
     */
    public function byId(int $id): ?Format
    {
        return Format::query()->find($id);
    }

    /**
     * {@inheritDoc}
     */
    public function byName(string $formatName): ?Format
    {
        return Format::where('format', $formatName)->first();
    }

    /**
     * {@inheritDoc}
     */
    public function getOrGetNew(array $data): ?Format
    {
        return Format::firstOrCreate($data);
    }

    /**
     * {@inheritDoc}
     */
    public function store(Format $format): bool
    {
        return $format->save();
    }

    /**
     * {@inheritDoc}
     */
    public function update(int $id, array $data): bool
    {
        return Format::where('id', $id)->update($data);
    }

    /**
     * {@inheritDoc}
     */
    public function delete(int $id): bool
    {
        return Format::destroy($id);
    }
}
