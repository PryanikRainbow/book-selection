<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use App\Models\Book;
use Illuminate\Http\Response;

class DeleteBookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id)
    {
        if (!Book::where('id', $id)->exists()) {
            return new Response(['error' => 'Book not found'], 404);
        }

        $this->bookService->deleteBook($id);

        return new Response([], Response::HTTP_OK);
    }
}
