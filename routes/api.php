<?php

use App\Http\Controllers\CastMember\CreateCastMemberController;
use App\Http\Controllers\CastMember\DeleteCastMemberController;
use App\Http\Controllers\CastMember\ListCastMemberController;
use App\Http\Controllers\CastMember\UpdateCastMemberController;
use App\Http\Controllers\Category\CreateCategoryController;
use App\Http\Controllers\Category\DeleteCategoryController;
use App\Http\Controllers\Category\ListCategoryController;
use App\Http\Controllers\Category\UpdateCategoryController;
use App\Http\Controllers\Genre\CreateGenreController;
use App\Http\Controllers\Genre\DeleteGenreController;
use App\Http\Controllers\Genre\ListGenreController;
use App\Http\Controllers\Genre\UpdateGenreController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/create-category', CreateCategoryController::class);
Route::get('/list-categories', ListCategoryController::class);
Route::put('/update-category/{id}', UpdateCategoryController::class);
Route::delete('/delete-category/{id}', DeleteCategoryController::class);

Route::post('/create-genre', CreateGenreController::class);
Route::get('/list-genres', ListGenreController::class);
Route::put('/update-genre/{id}', UpdateGenreController::class);
Route::delete('/delete-genre/{id}', DeleteGenreController::class);

Route::post('/create-cast-member', CreateCastMemberController::class);
Route::get('/list-cast-members', ListCastMemberController::class);
Route::put('/update-cast-member/{id}', UpdateCastMemberController::class);
Route::delete('/delete-cast-member/{id}', DeleteCastMemberController::class);
