<?php

use App\Http\Controllers\Category\CreateCategoryController;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Controllers\Category\ListCategoryController;
use App\Http\Controllers\Category\UpdateCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-category', CreateCategoryController::class);
Route::get('/list-categories', ListCategoryController::class);
Route::put('/update-category/{id}', UpdateCategoryController::class);
Route::delete('/delete-category/{id}', DeleteCategoryController::class);
