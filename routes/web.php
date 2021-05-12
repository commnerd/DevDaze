<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AppController;
use App\Http\Controllers\DockerImageController;

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

Route::get('/', [AppController::class, 'index'])->name('apps.index');
Route::resource('apps', AppController::class)->except(['index', 'show']);
Route::name('apps.')->prefix('apps')->group(function() {
    Route::resource('{app}/docker_images', DockerImageController::class)->except(['index', 'show']);
});
