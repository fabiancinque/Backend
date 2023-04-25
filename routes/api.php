<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\v1\ApiController;
use App\Http\Controllers\Api\v1\AuthController;

Route::group([
    'prefix' => 'v1/auth'
], function ($router) {
    Route::post('login', [AuthController::class, 'login'])->name('login');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('me', [AuthController::class, 'me'])->name('me');
});

Route::group([
    'middleware' => 'auth:api',
    'prefix' => 'v1'
], function () {
    Route::get('people', [ApiController::class, 'getPeople'])->name('getPeople');
    Route::get('people/{id}', [ApiController::class, 'getPeopleById'])->name('getPeopleById');
    Route::get('planets', [ApiController::class, 'getPlanets'])->name('getPlanets');
    Route::get('planets/{id}', [ApiController::class, 'getPlanetById'])->name('getPlanetById');
    Route::get('vehicles', [ApiController::class, 'getVehicles'])->name('getVehicles');
    Route::get('vehicles/{id}', [ApiController::class, 'getVehicleById'])->name('getVehicleById');
});
