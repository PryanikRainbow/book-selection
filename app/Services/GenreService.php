<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Genre;
use Exception;
use Illuminate\Support\Facades\Log;

class GenreService
{
    /**
     * @param array $data
     *
     * @return Genre
     */
    public function create(array $data): Genre
    {
        try {
            /** @var Genre $genre */
            $genre = Genre::create($data);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong: Attempt to create genre failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $data,
                ]
            );

            throw new AppException('Something went wrong: Attempt to create genre failed');
        }

        return $genre;
    }

}
