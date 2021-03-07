<?php

use App\Http\Controllers\AuthController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::post('/auth/register', [AuthController::class, 'register']);

Route::post('/auth/login', [AuthController::class, 'login']);

Route::group(['middleware' => ['auth:sanctum']], function () {
    Route::get('user', function(Request $request) {
        return $request->user();
    });

    Route::get('wallet', function () {
       return auth()->user()->wallet;
    });

    Route::get('payments', function () {
       return auth()->user()->payments()->orderBy('created_at','desc')->get();
    });

    Route::post('/auth/logout', [AuthController::class, 'logout']);
});
