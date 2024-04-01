<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Http\Response;

class GetBooksListInfoController extends Controller
{
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(Request $request): Response
    {
        return new Response([$this->bookService->booksListInfo()]);
    }
}
