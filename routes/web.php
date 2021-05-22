<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\DockerImageController;
use App\Http\Controllers\CatchAllController;
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

Route::any('{catchall}', [CatchAllController::class, 'handle'])
    ->where('catchall', '.*');
