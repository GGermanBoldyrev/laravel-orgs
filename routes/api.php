<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrganizationController;
use App\Http\Controllers\Api\BuildingController;
use App\Http\Controllers\Api\ActivityController;

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

// API Routes with API Key authentication
Route::middleware('api.key')->group(function () {

    // Organizations
    Route::prefix('organizations')->group(function () {
        Route::get('/', [OrganizationController::class, 'index']);
        Route::get('/{organization}', [OrganizationController::class, 'show']);
        Route::get('/building/{building}', [OrganizationController::class, 'byBuilding']);
        Route::get('/activity/{activity}', [OrganizationController::class, 'byActivity']);
        Route::get('/search/name', [OrganizationController::class, 'searchByName']);
        Route::get('/search/activity/{activity}', [OrganizationController::class, 'searchByActivity']);
        Route::get('/nearby', [OrganizationController::class, 'nearby']);
    });

    // Buildings
    Route::prefix('buildings')->group(function () {
        Route::get('/', [BuildingController::class, 'index']);
        Route::get('/{building}', [BuildingController::class, 'show']);
    });

    // Activities
    Route::prefix('activities')->group(function () {
        Route::get('/', [ActivityController::class, 'index']);
        Route::get('/{activity}', [ActivityController::class, 'show']);
        Route::get('/tree', [ActivityController::class, 'tree']);
    });
});
