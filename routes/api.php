<?php

use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user()->load('posts');
})->middleware(['auth:sanctum']);

Route::get('/posts', [PostController::class, 'index']);
Route::post('/posts', [PostController::class, 'store'])->middleware('auth:sanctum');
Route::get('/post/{post:slug}', [PostController::class, 'show']);
Route::put('/post/{post:slug}', [PostController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/post/{post:slug}', [PostController::class, 'destroy'])->middleware('auth:sanctum');

Route::get('/categories', [CategoryController::class, 'index']);
Route::post('/categories', [CategoryController::class, 'store'])->middleware('auth:sanctum');
Route::get('/category/{category:slug}', [CategoryController::class, 'show']);
Route::put('/category/{category:slug}', [CategoryController::class, 'update'])->middleware('auth:sanctum');
Route::delete('/category/{category:slug}', [CategoryController::class, 'destroy'])->middleware('auth:sanctum');

Route::post('/post/{post:slug}/comment', [CommentController::class, 'store'])->middleware('auth:sanctum');
