<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Jobs\ImportData\ImportBooksDataJob;
// use App\Jobs\ImportBooksDataJob;
use App\Models\Book;

class ImportBooksController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request)
    {
        ImportBooksDataJob::dispatch(base_path() . Book::TEST_DATA_FILEPATH);
    }
}
