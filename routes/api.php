<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OwnerApiController;
use App\Http\Controllers\Api\CarApiController;

Route::apiResource('owners', OwnerApiController::class)
    ->names('api.owners');

Route::apiResource('cars', CarApiController::class)
    ->names('api.cars');