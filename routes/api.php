<?php

use App\Http\Controllers\ProfilCommentController;
use App\Http\Controllers\ProfilController;
use Illuminate\Support\Facades\Route;

// TODO: As routes have such different roles (admin vs public), it might be go to separate their declarations and controllers
Route::apiResource('profils', ProfilController::class)
    ->only(['index', 'store', 'update', 'destroy']);

Route::prefix('profils')->name('profils.')->group(function () {
    Route::apiResource('{profil}/comments', ProfilCommentController::class)
        ->middleware('auth:sanctum')
        ->only(['store']);

});
