<?php

use App\Http\Controllers\EditorController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->middleware('guest')->name('homepage');
Route::get('/about', [HomeController::class, 'about'])->middleware('guest')->name('about');
Route::get('/subperks', [HomeController::class, 'subperks'])->middleware('guest')->name('subperks');

Route::prefix('editor')->name('editor.')->group(function () {
    Route::get('/', [EditorController::class, 'editorIndex'])->name('index');
    Route::get('/denied', [EditorController::class, 'editorDenied'])->name('denied');
});
