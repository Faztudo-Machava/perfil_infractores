<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CondutorController;
use App\Http\Controllers\InfraccaoController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegraTransitoController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::get('users',[UserController::class, 'index']);
Route::post('auth/login', [AuthController::class, 'login']);
Route::apiResource('usuario', UserController::class);
Route::apiResource('regra', RegraTransitoController::class);
Route::get('usuarioAtual', [AuthController::class, 'currentUser']);
Route::post('auth/logout', [AuthController::class, 'logout']);
Route::apiResource('condutor', CondutorController::class);
Route::apiResource('infraccao', InfraccaoController::class);
Route::apiResource('Perfil', PerfilController::class);
