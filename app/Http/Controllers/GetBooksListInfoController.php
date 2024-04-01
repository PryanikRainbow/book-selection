<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Response;

class GetBooksListInfoController extends Controller
{
    /**
     * @param BookService $bookService
     */
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     *
     * @return Response $response
     */
    public function __invoke(): Response
    {
        return new Response([$this->bookService->booksListInfo()]);
    }
}
