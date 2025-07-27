<?php

use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\Api\RegisterController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PostsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/* Authentication Routes */
Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

/* Posts Routes */
Route::apiResource('/posts', PostsController::class);

/* Categories Routes */
Route::post('/categories', CategoriesController::class . '@store');
Route::get('/categories/admin', CategoriesController::class . '@index');
Route::get('/categories', CategoriesController::class . '@getActiveCategories');
Route::put('/categories/{id}', CategoriesController::class . '@update');
Route::delete('/categories/{id}', CategoriesController::class . '@destroy');
