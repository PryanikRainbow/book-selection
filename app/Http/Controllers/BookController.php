<?php

namespace App\Http\Controllers;

use App\Http\Requests\BaseListRequest;
use App\Http\Resources\Book\BookResource;
use App\Http\Requests\Book\CreateBookRequest;
use App\Http\Requests\Book\ImportBooksRequest;
use App\Http\Requests\Book\UpdateBookRequest;
use App\Http\Resources\Book\BookItemResource;
use App\Jobs\ImportData\ImportBooksDataJob;
use App\Models\Book;
use App\Services\BookService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class BookController extends Controller
{
    /**
     * @param BookService $bookService
     */
    public function __construct(private BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    /**
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function index(BaseListRequest $request): JsonResponse
    {
        /** @var LengthAwarePaginator $books  */
        $books = $this->bookService->getList($request->validated());

        return response()->json([
            'data' => BookItemResource::collection($books),
            'meta' => [
                'count'          => count($books->items()),
                'first'          => $books->currentPage() === 1,
                'last'           => $books->lastPage() === $books->currentPage(),
                'page'           => $books->currentPage(),
                'size'           => $books->perPage(),
                'total_count'    => $books->total(),
                'total_pages'    => $books->lastPage(),
            ],
        ], Response::HTTP_OK);
    }

    /**
     * @param Book $book
     *
     * @return JsonResponse
     */
    public function show(Book $book): JsonResponse
    {
        return response()->json(
            BookResource::make($book),
            Response::HTTP_OK,
        );
    }

    /**
     * @param CreateBookRequest $request
     *
     * @return JsonResponse
     */
    public function create(CreateBookRequest $request): JsonResponse
    {
        return response()->json(
            BookResource::make($this->bookService->create($request->validated())),
            Response::HTTP_CREATED
        );
    }

    /**
     * @param UpdateBookRequest $request
     * @param Book $book
     *
     * @return JsonResponse
     */
    public function update(UpdateBookRequest $request, Book $book): JsonResponse
    {
        return response()->json(
            BookResource::make($this->bookService->update($book, $request->validated())),
            Response::HTTP_OK,
        );
    }

    /**
     * @param Book $book
     *
     * @return JsonResonse
     */
    public function remove(Book $book): JsonResponse
    {
        $this->bookService->delete($book);

        return response()->json([], Response::HTTP_OK,);
    }

    public function import(ImportBooksRequest $request)
    {
        $path = $request->file('file')->store('uploads');

        ImportBooksDataJob::dispatch($path);

        return response()->json([], Response::HTTP_CREATED);
    }
}
