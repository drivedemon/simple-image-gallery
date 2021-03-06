<?php
header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Origin Content-Type, X-Requested-With, X-Auth-Token, Authorization, Accept,charset,boundary,Content-Length');
header('Access-Control-Allow-Origin: *');

use App\Http\Controllers\FileUploadsController;
use App\Http\Controllers\SessionsController;
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
Route::post('detail', function () {
    return 'test';
})->name('detail');

Route::post('login', [SessionsController::class, 'login'])->name('login');
Route::post('register', [SessionsController::class, 'register'])->name('register');
Route::post('upload', [FileUploadsController::class, 'upload'])->name('upload');
Route::get('fetch/{id}', [FileUploadsController::class, 'fetch'])->name('fetch');
Route::get('information/{id}', [FileUploadsController::class, 'information'])->name('information');

