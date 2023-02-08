<?php

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::group([
    'as' => "api.",
    'namespace' => "App\Http\Controllers\Api",
    'middleware' => 'auth:sanctum'
], function() {
    Route::group([
       "notification.",
       'prefix' => "notifications",
       'as' => "notifications."
    ], function() {
        Route::get("/", "NotificationController@index")
            ->name('index');
        Route::post("/", "NotificationController@store")
            ->name('store');
        Route::get("/{id}", "NotificationController@show")
            ->name('show');
        Route::put("/{id}", "NotificationController@update")
            ->name('update');
        Route::delete("/{id}", "NotificationController@destroy")
            ->name('destroy');
    });
});
