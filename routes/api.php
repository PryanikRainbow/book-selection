<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ImportBooksController;
use App\Http\Controllers\PostTestController;
use App\Http\Controllers\GetBooksListInfoController;
use App\Http\Controllers\GetBookInfoController;
use App\Http\Controllers\CreateBookController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
Route::post('/import-books-data', ImportBooksController::class);
Route::post('/book/create', CreateBookController::class);
Route::get('/list', GetBooksListInfoController::class);
Route::get('/book/{id}', GetBookInfoController::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
