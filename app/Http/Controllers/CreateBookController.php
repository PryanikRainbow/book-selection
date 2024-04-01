<?php

namespace App\Http\Controllers;

use App\Services\BookService;
use Illuminate\Http\Response;
use App\Http\Requests\CreateBookRequest;

class CreateBookController extends Controller
{
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     *
     * @param CreateBookRequest $request
     *
     * @return Response
     */
    public function __invoke(CreateBookRequest $request): Response
    {

        $this->bookService->createOrUpdate($request->all());

        return new Response([], Response::HTTP_CREATED);
    }
}
