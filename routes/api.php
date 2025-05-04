<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Resources\Auth\LoginResource;
use App\Http\Controllers\Api\Auth\LoginController;
use App\Http\Controllers\Api\Auth\LogoutController;
use App\Http\Controllers\Api\Auth\RegisterController;


Route::post('login', LoginController::class)->name('login');
Route::post('register', RegisterController::class)->name('register');



Route::get('/user', function (Request $request) {
    return new LoginResource($request->user());
})->middleware('auth:sanctum')->name('user');
Route::group(['middleware' => 'auth:sanctum'], function(){
    Route::post('logout', LogoutController::class)->name('logout');
});
