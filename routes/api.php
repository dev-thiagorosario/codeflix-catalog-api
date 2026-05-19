<?php

use App\Http\Controllers\Category\CreateCategoryController;
use App\Http\Controllers\Category\ListCategoryController;
use App\Http\Controllers\Category\UpdateCategoryController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-category', CreateCategoryController::class)->middleware('auth:sanctum');
Route::get('/list-categories', ListCategoryController::class)->middleware('auth:sanctum');
Route::put('/update-category/{id}', UpdateCategoryController::class)->middleware('auth:sanctum');
