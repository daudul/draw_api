<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

//Route::get('/user', function (Request $request) {
//    return $request->user();
//})->middleware('auth:sanctum');

Route::controller(AuthController::class)->group(function (){
    Route::post('register', 'register');
    Route::post('login', 'login');
    Route::post('refresh', 'refresh');
});

Route::group(['middleware' => 'auth:api'], function ($e){
    Route::group(['prefix' => 'event'], function (){
        Route::controller(EventController::class)->group(function (){
            Route::post('store', 'store');
            Route::get('list', 'index');
            Route::patch('show/{event}', 'show');
        });
    });
});




