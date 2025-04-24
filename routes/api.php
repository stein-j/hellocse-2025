<?php

use App\Http\Controllers\ProfilCommentController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

Route::apiResource('profils', ProfilController::class)
    ->only(['index', 'store']);

Route::prefix('profils')->name('profils.')->group(function () {
    Route::apiResource('{profil}/comments', ProfilCommentController::class)
        ->middleware('auth:sanctum')
        ->only(['store']);

});
