<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ShortenerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

/**
 * @Route ("/api/shortener/{shortUrl}", name="", methods={"GET"})
 */
Route::get('shortener/more-accessed', [ShortenerController::class, 'getMoreAccessed']);

/**
 * @Route ("/api/shortener/store", name="", methods={"POST"})
 */
Route::post('shortener/store', [ShortenerController::class, 'store']);
