<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use Illuminate\Http\Response;
use App\Http\Requests\UpdateBookRequest;

class UpdateBookController extends Controller
{
    /**
     * @param BookService $bookService
     */
    public function __construct(private BookService $bookService)
    {
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(UpdateBookRequest $request): Response
    {
        $this->bookService->createOrUpdate($request->all());

        return new Response([], Response::HTTP_OK);
    }
}
