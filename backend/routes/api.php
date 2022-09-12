<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\MovieController;
use App\Http\Controllers\TurnController;
use App\Http\Controllers\AssignmentController;
use App\Http\Controllers\AuthController;

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
Route::middleware('auth:sanctum')->group(function() {
    Route::prefix('movies')->group(function () {
        Route::get('/', [MovieController::class, 'index']);
        Route::get('/{id}', [MovieController::class, 'show']);
        Route::post('/', [MovieController::class, 'store']);
        Route::put('/{id}', [MovieController::class, 'update']);
        Route::delete('/{id}', [MovieController::class, 'delete']);
    });
    
    Route::prefix('turns')->group(function () {
        Route::get('/', [TurnController::class, 'index']);
        Route::get('/{id}', [TurnController::class, 'show']);
        Route::post('/', [TurnController::class, 'store']);
        Route::put('/{id}', [TurnController::class, 'update']);
        Route::delete('/{id}', [TurnController::class, 'delete']);
    });
    
    Route::prefix('assignments')->group(function () {
        Route::post('/', [AssignmentController::class, 'store']);
    });
});

Route::post('/login', [AuthController::class, 'login']);

Route::get('unauthorized', function () {
    return response()->json(['error' => 'Unauthorized.'], 401);
})->name('unauthorized');
