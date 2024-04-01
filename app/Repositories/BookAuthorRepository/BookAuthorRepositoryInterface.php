<?php

namespace App\Repositories\BookAuthor;

use App\Models\BookAuthor;
use Illuminate\Database\Eloquent\Collection;

interface BookAuthorRepositoryInterface
{
    /**
     * @param array $data
     *
     * @return BookAuthor|null
     */
    public function getOrGetNew(array $data): ?BookAuthor;

}
