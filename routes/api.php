<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Cms\UserController;

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

Route::group(['prefix' => 'wucms'], function () {
    Route::post('/user/reg', [UserController::class, 'register']);
    Route::post('/user/login', [UserController::class, 'login']);

    Route::group(['middleware' => 'auth:api'], function(){
        Route::post('/details', [UserController::class,'details']);
    });



});


Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
