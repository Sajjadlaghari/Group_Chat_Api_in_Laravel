<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\MessagesController;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('get_users',[ UserController::class,'get_users']);
Route::post('registration',[ UserController::class,'registration']);
// Route::delete('delete_employee/{id}',[ UserController::class,'delete_employee']);
// Route::post('update_employee/{id}',[ UserController::class,'update_employee']);
Route::post('login',[ UserController::class,'login_user']);


Route::get('get_all_messages',[ MessagesController::class,'get_all_messages']);
Route::post('send_message',[ MessagesController::class,'send_message']);