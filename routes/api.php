<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\FixtureController;
use App\Http\Controllers\Api\PlayerController;
use App\Http\Controllers\Api\StandingController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('v1')->group(function () {
    // Auth routes
    Route::post('login', [AuthController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::post('logout', [AuthController::class, 'logout']);
        Route::get('me', [AuthController::class, 'me']);
    });
});

Route::prefix('v1')->group(function () {
    // Fixtures endpoints
    Route::get('fixtures', [FixtureController::class, 'index']);
    Route::get('fixtures/upcoming', [FixtureController::class, 'upcoming']);
    Route::get('fixtures/completed', [FixtureController::class, 'completed']);
    
    // Standings endpoint
    Route::get('standings', [StandingController::class, 'index']);
    
    // Players endpoints
    Route::get('players', [PlayerController::class, 'index']);
    Route::get('players/top-scorers', [PlayerController::class, 'topScorers']);
    Route::get('players/top-assists', [PlayerController::class, 'topAssists']);

    // Admin routes (protected)
    Route::middleware('auth:sanctum', 'admin')->group(function () {
        Route::put('fixtures/{fixture}', [FixtureController::class, 'update']);
        Route::post('fixtures/{fixture}/scores', [FixtureController::class, 'updateScores']);
    });
});