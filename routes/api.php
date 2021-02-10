<?php

use App\Http\Controllers\ApiController;
use Facade\FlareClient\Api;
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

Route::middleware(['api', 'guest', 'throttle:10,1'])->prefix('schedule')->name('schedule.')->group(function () {
    Route::get('/', [ApiController::class, 'scheduleList'])->name('list');
    Route::get('/next', [ApiController::class, 'scheduleNext'])->name('next');
});

Route::get('/youtube', [ApiController::class, 'fetchYouTube'])->name('youtube');
