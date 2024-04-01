<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Response;
use App\Http\Requests\BookRequest;

class CreateBookController extends Controller
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
     * @param BookRequest $request
     *
     * @return Response
     */
    public function __invoke(BookRequest $request): Response
    {

        $this->bookService->createOrUpdate($request->all());

        return new Response([], Response::HTTP_CREATED);
    }
}
