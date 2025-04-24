<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('profils', \App\Http\Controllers\ProfilController::class)
    ->middleware('auth:sanctum')
    ->only(['store']);

