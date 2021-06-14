<?php

use App\Http\Controllers\MedicineController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;

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


/**
 * @group Gestão de utilizadores
 *
 * Retorna o utilizador autenticado
 *
 * @response scenario=success status=200 {
 *    "id": 4,
 *    "name": "Zé Ninguem",
 *    "email": "ze.ninguem@mail.pt",
 *    "email_verified_at": "2021-06-11T20:22:25.000000Z",
 *    "created_at": "2021-06-11T20:22:26.000000Z",
 *    "updated_at": "2021-06-11T20:22:26.000000Z"
 * }
 */
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('user', [UserController::class, 'create']);
Route::apiResource('medicine', MedicineController::class)->middleware('auth:sanctum');
