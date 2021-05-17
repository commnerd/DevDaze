<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DockerImageController;
use App\Http\Controllers\GroupController;

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

Route::get('/', [GroupController::class, 'index'])->name('groups.index');
Route::resource('groups', GroupController::class)->except(['index', 'show']);
Route::name('groups.')->prefix('groups')->group(function() {
    Route::resource('{group}/docker_images', DockerImageController::class)->except(['index', 'show']);
});
