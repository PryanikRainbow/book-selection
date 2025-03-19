<?php

namespace App\Services;

use App\Exceptions\AppException;
use App\Models\Author;
use Exception;
use Illuminate\Support\Facades\Log;

class AuthorService
{
    /**
     * @param array $data
     *
     * @return Author
     */
    public function create(array $data): Author
    {
        try {
            /** @var Author $author */
            $author = Author::create($data);
        } catch (\Exception $e) {
            Log::error(
                'Something went wrong: Attempt to create author failed',
                [
                    'message' => $e->getMessage(),
                    'input'   => $data,
                ]
            );

            throw new AppException('Something went wrong: Attempt to create author failed');
        }

        return $author;
    }

}
