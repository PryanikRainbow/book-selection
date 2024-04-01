<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Http\Response;

class CreateBookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     * @param Request $request
     *
     * @return Response
     */
    public function __invoke(Request $request): Response
    {

        $this->bookService->createOrUpdate($request->all());
        return new Response([], Response::HTTP_CREATED);
    }
}
