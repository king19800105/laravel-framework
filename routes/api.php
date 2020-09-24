<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\{
    UserController
};

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

// 限流组件使用：->middleware(['throttle:uploads'])
Route::group(['prefix' => 'v1', 'middleware' => ['api']], function ($router) {
    $router->group(['prefix' => 'user-center'], function ($router) {
        $router->resource('personal', UserController::class);
    });
});
