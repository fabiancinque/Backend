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

Route::group(['middleware' => 'auth:api'], function () {
    Route::get('v1/people', [ApiController::class, 'getPeople'])->name('getPeople');
    Route::get('v1/people/{id}', [ApiController::class, 'getPeopleById'])->name('getPeopleById');
    Route::get('v1/planets', [ApiController::class, 'getPlanets'])->name('getPlanets');
    Route::get('v1/planets/{id}', [ApiController::class, 'getPlanetById'])->name('getPlanetById');
    Route::get('v1/vehicles', [ApiController::class, 'getVehicles'])->name('getVehicles');
    Route::get('v1/vehicles/{id}', [ApiController::class, 'getVehicleById'])->name('getVehicleById');
});
