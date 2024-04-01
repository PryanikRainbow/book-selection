<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\BookService;
use App\Http\Requests\GetBookInfoRequest;
use Illuminate\Http\Response;

class GetBookInfoController extends Controller
{
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * Handle the incoming request.
     */
    public function __invoke(int $id): Response
    {
        return new Response([$this->bookService->bookInfo($id)]);
    }
}
