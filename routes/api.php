<?php

use App\Http\Controllers\Public\PublicController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::post('/xendit/callback', [PublicController::class, 'handleCallback']);
Route::get('/users', [PublicController::class, 'get_api_users']);

