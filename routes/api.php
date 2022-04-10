<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TodaysOrderController;

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

// basic route
// Route::get('/index', [TodaysOrderController::class, 'index']);

Route::get('/order', function(){
    $response = Http::get('https://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/items.jsonhttps://storage.googleapis.com/neta-interviews/MJZkEW3a8wmunaLv/items.json');

    return $response;
});
