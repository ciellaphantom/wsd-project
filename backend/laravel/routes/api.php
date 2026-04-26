<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\TaskController;

Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
    ], 200);
});

Route::prefix('78709/v1')->group(function () {
    Route::apiResource('tasks', TaskController::class);
});