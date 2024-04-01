<?php

namespace App\Jobs\ImportData;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Services\BookService;
use Exception;

class ImportBooksDataJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public int $timeout        = 600;
    public const AUTHORS_INDEX = 0;
    public const GENRES_INDEX  = 2;
    public const DATA_MAPPING = [
        'authors',
        'title',
        'genres',
        'description',
        'edition',
        'publisher',
        'release_date',
        'format',
        'pages',
        'country',
        'ISBN',
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
     * @return void
     */
    public function handle(): void
    {
        try {
            $fullFilePath = base_path() . '/storage/app/' . $this->filePath;
            $file = fopen($fullFilePath, 'r');

            if ($this->ignoreHeadCol) {
                fgetcsv($file);
            }

            DB::beginTransaction();
            $bookService = app(BookService::class);

            while (($row = fgetcsv($file)) !== false) {
                $row[self::AUTHORS_INDEX] = explode(';', $row[self::AUTHORS_INDEX]);
                $row[self::GENRES_INDEX] = explode(';', $row[self::GENRES_INDEX]);
                $bookService->bookInsertOrUpdate(array_combine(self::DATA_MAPPING, $row));
            }

            fclose($file);
            unlink($fullFilePath);

            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            Log::error($e->getMessage());
        }
    }
}
