<?php

use Illuminate\Http\Request;
use App\Http\Controllers\UserController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\WorkShiftController;
use App\Http\Controllers\OrderController;
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

Route::get('users', function () {
    return "Hello World!";
});

Route::get('roles', function () {
    return \App\Models\Role::all();
});

Route::prefix('user')->group(function() {
    Route::get('/', function () {
        return \App\Models\User::all();
    });

    Route::get('/{user}', [UserController::class, 'show']);
});

Route::resource('user', UserController::class, ['only' => ['index', 'show']]);

Route::resource('user', UserController::class, ['except' => ['create', 'update']]);

Route::apiResource('user', UserController::class);

Route::resource('role', RoleController::class);

//Аутентификация и выход
Route::post('/login', [UserController::class, 'login'])->withoutMiddleware('auth:php');
Route::get('/logout', [UserController::class, 'logout'])->middleware('auth:api');

//Просмотр всех сотрудников и добавление нового
Route::apiResource('user',
    UserController::class, ['only' => ['index', 'store']])
        ->middleware('role:admin');

//Работа со сменой
Route::prefix('work-shift')->group(function () {
    Route::post('/', [WorkShiftController::class, 'store']);
    Route::get('/{workShift}/open', [WorkShiftController::class, 'open']);
    Route::get('/{workShift}/close', [WorkShiftController::class, 'close']);

    Route::post('/{workShift}/user', [WorkShiftController::class, 'addUser']);
    Route::get('/{workShift}/order', [WorkShiftController::class, 'orders']);
});

//Просмотр конкретного заказа, создание заказа для столика
Route::apiResource('/order', OrderController::class, ['only' => ['show', 'store']]);

Route::prefix('order')->group(function () {
    Route::post('/{order}/position', [OrderController::class, 'addPosition']);
    Route::delete('/{order}/position/{orderMenu}', [OrderController::class, 'removePosition']);
    Route::patch('/{order}/change-status', [OrderController::class, 'changeStatus']);
});

//Просмотр заказов текущей смены
Route::get('/taken', [OrderController::class,'takenOrders']);
/*Route::get('/{workShift}/order', [WorkShiftController::class, 'orders']);*/


