<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Response;
use App\Models\Book;

class GetBookInfoController extends Controller
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
     * @param int $id
     */
    public function __invoke(int $id): Response
    {
        if (!Book::where('id', $id)->exists()) {
            return new Response(['error' => 'Book not found'], 404);
        }

        return new Response([$this->bookService->bookInfo($id)]);
    }
}
