<?php

use App\Http\Controllers\ShortLinkController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/', [ShortLinkController::class, 'createForm'])->name('link.form');
Route::post('/create', [ShortLinkController::class, 'create'])->name('link.create');
Route::get('/{shortLink}', [ShortLinkController::class, 'redirect'])->name('link.redirect');
