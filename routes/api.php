<?php

use App\Http\Controllers\ProfilCommentController;
use Illuminate\Support\Facades\Route;

Route::apiResource('profils', \App\Http\Controllers\ProfilController::class)
    ->middleware('auth:sanctum')
    ->only(['store']);

Route::prefix('profils')->name('profils.')->group(function () {
    Route::apiResource('{profil}/comments', ProfilCommentController::class)
        ->middleware('auth:sanctum')
        ->only(['store']);

});
