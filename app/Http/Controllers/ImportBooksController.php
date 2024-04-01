<?php

namespace App\Http\Controllers;

use App\Jobs\ImportData\ImportBooksDataJob;
use App\Http\Requests\ImportBooksRequest;
use Illuminate\Http\Response;

class ImportBooksController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param ImportBooksRequest $request
     */
    public function __invoke(ImportBooksRequest $request)
    {
        $path = $request->file('file')->store('uploads');

        ImportBooksDataJob::dispatch($path);

        return new Response([], Response::HTTP_CREATED);
    }
}
