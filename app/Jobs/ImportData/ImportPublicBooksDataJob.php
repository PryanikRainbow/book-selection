<?php

namespace App\Jobs\ImportData;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\Author;
use App\Models\Country;
use App\Models\Format;
use App\Models\Genre;
use App\Models\Book;
use App\Models\Publisher;
use Exception;


/**
 * @TODO repo
 */
// @TODO change className
class ImportBooksDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout      = 600;
    public const DATA_MAPPING = [
        'authors'      => 0,
        'title'        => 1,
        'genre'        => 2,
        'description'  => 3,
        'edition'      => 4,
        'publisher'    => 5,
        'release_date' => 6,
        'format'       => 7,
        'pages'        => 8,
        'country'      => 9,
        'ISBN'         => 10,
    ];

    /**
     * @param string $filePath
     * @param bool   $ignoreHeadCol
     */
    public function __construct(
        private string $filePath,
        private bool $ignoreHeadCol = true
    ) {
    }

    /**
     * @return
     */
    public function handle(): void
    {
        try {
            $file = fopen($this->filePath, 'r');

            if ($this->ignoreHeadCol) {
                fgetcsv($file);
            }

            DB::beginTransaction();

            while (($row = fgetcsv($file)) !== false) {

                $authorsIds  = $this->authorsImport(explode(';', $row[self::DATA_MAPPING['authors']]));
                $genreIds    = $this->genresImport(explode(';', $row[self::DATA_MAPPING['genre']]));
                $countryId   = $this->countryImport($row[self::DATA_MAPPING['country']]);
                $publisherId = $this->publisherImport($row[self::DATA_MAPPING['publisher']]);
                $formatId    = $this->formatImport($row[self::DATA_MAPPING['format']]);
                $bookId      = $this->bookImport($row, $countryId, $publisherId, $formatId);
                $this->bookAuthorsImport($bookId, $authorsIds);
                $this->bookGenresImport($bookId, $genreIds);
            }

            fclose($file);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }

    /**
     * @param array $authors
     *
     * @return array
     */
    private function authorsImport(array $authors): array
    {
        $authorIds = [];

        foreach ($authors as $authorName) {
            $authorIds[] = Author::firstOrCreate(['name' => $authorName])->id;
        }

        return $authorIds;
    }

    /**
     * @param array $genres
     *
     * @return array
     */
    private function genresImport(array $genres): array
    {
        $genreIds = [];

        foreach ($genres as $genre) {
            $genreIds[] = Genre::firstOrCreate(['name' => $genre])->id;
        }

        return $genreIds;
    }

    /**
     * @param string country
     *
     * @return int
     */
    private function countryImport(string $country): int
    {
        return Country::firstOrCreate(['country_name' => $country])->id;
    }


    /**
     * @param string format
     *
     * @return int
     */
    private function formatImport(string $format): int
    {
        return Format::firstOrCreate(['format' => $format])->id;
    }

    /**
     * @param string publisher
     *
     * @return int
     */
    private function publisherImport(string $publisher): int
    {
        return Publisher::firstOrCreate(['name' => $publisher])->id;
    }

    /**
     * @param array data
     *
     * @return int
     */
    private function bookImport(array $data, int $countryId, int $publisherId, int $formatId): int
    {
        $edition = is_numeric($data[self::DATA_MAPPING['edition']]) ? $data[self::DATA_MAPPING['edition']] : null;

        $book = Book::firstOrCreate([
            'title'        => $data[self::DATA_MAPPING['title']],
            'description'  => $data[self::DATA_MAPPING['description']],
            'edition'      => $edition,
            'publisher_id' => $publisherId,
            'release_date' => $data[self::DATA_MAPPING['release_date']],
            'format_id'    => $formatId,
            'pages'        => $data[self::DATA_MAPPING['pages']],
            'country_id'   => $countryId,
            'ISBN'         => $data[self::DATA_MAPPING['ISBN']],
        ]);

        return $book->id;
    }

    /**
     * @param int   $bookId
     * @param array $authorsIds
     *
     * @return $void
     */
    private function bookAuthorsImport(int $bookId, array $authorIds): void
    {
        $book = Book::find($bookId);

            $book->authors()->sync($authorIds);
    
    }

    /**
     * @param int   $bookId
     * @param array $genreIds
     *
     * @return $void
     */
    private function bookGenresImport(int $bookId, array $genreIds): void
    {
        $book = Book::find($bookId);
        $book->genres()->sync($genreIds);
    }
}
