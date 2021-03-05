<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\{
    LoginController,
    PasswordController,
    AdminController,
    UserController,
    PermissionController,
    RoleController,
    ArticleController
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


// 限流组件使用：middleware(['throttle:uploads'])
// 断路器组件使用：middleware('breaker:permission.handler')
// 操作日志组件使用：middleware('operate:角色模块')
// 布隆过滤器组件使用：resource路由 middleware('bloom:role')，普通路由 middleware('bloom:role,GET')
Route::group(['prefix' => 'auth/v1', 'middleware' => ['api']], function ($router) {
    // 用户相关
    $router->post('register', [LoginController::class, 'register']);
    $router->get('login', [LoginController::class, 'login'])->middleware(['throttle:userLogin']);
    $router->get('logout', [LoginController::class, 'logout']);
    $router->put('reset-password', [PasswordController::class, 'resetPassword']);
    $router->put('forget-password', [PasswordController::class, 'forgetPassword']);

    // 管理员相关
    $router->get('admin-login', [LoginController::class, 'adminLogin'])->middleware(['throttle:auth']);
    $router->get('admin-logout', [LoginController::class, 'adminLogout']);
    $router->put('admin-reset-password', [PasswordController::class, 'adminResetPassword']);
});

// 管理员端
Route::group(['prefix' => 'backend/v1', 'middleware' => ['api', 'auth:admin']], function ($router) {
    $router->resource('admin', AdminController::class);
    $router->resource('user', UserController::class);
    $router->resource('permission', PermissionController::class);
    $router->resource('role', RoleController::class);
});

// 用户中心
Route::group(['prefix' => 'user-center/v1', 'middleware' => ['api', 'auth:api', 'throttle:id']], function ($router) {
    $router->get('info', [UserController::class, 'getInfo']);
    $router->get('play-video', [UserController::class, 'playVideo']);
    $router->get('view-doc', [UserController::class, 'viewDoc']);
});

// 前台展示
Route::group(['prefix' => 'v1', 'middleware' => ['api']], function ($router) {
    $router->get('article/{id}', [ArticleController::class, 'show'])->middleware('limiter');
});





