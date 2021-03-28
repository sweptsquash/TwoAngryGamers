<?php

use App\Http\Controllers\EditorController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\VideosController;
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

Route::middleware(['api', 'guest', 'throttle:60,1'])->group(function () {
    Route::prefix('schedule')->name('schedule.')->group(function () {
        Route::get('/', [ScheduleController::class, 'scheduleList'])->name('list');
        Route::get('/next', [ScheduleController::class, 'scheduleNext'])->name('next');
    });

    Route::get('/youtube', [ScheduleController::class, 'fetchYouTube'])->name('youtube');

    Route::prefix('editor')->name('editor.')->group(function () {
        Route::post('/', [EditorController::class, 'index'])->name('list');
        Route::post('/me', [EditorController::class, 'me'])->name('me');
        Route::post('/store', [EditorController::class, 'store'])->name('store');
        Route::post('/{id}', [EditorController::class, 'show'])->name('show');
        Route::put('/{id}/update', [EditorController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [EditorController::class, 'delete'])->name('delete');
    });

    Route::prefix('videos')->name('videos.')->group(function () {
        Route::post('/', [VideosController::class, 'index'])->name('list');
        Route::post('/{id}', [VideosController::class, 'show'])->name('show');
        Route::put('/{id}/update', [VideosController::class, 'update'])->name('update');
        Route::delete('/{id}/delete', [VideosController::class, 'delete'])->name('delete');
        Route::get('/{id}/thumbnail', [VideosController::class, 'thumbnail'])->name('thumbnail');
        Route::get('/{id}/download', [VideosController::class, 'download'])->name('download');
    });
});
