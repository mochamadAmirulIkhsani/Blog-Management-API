<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\TagsController;
use App\Http\Controllers\PostsController;
use App\Http\Controllers\Api\LoginController;
use App\Http\Controllers\Api\LogoutController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\Api\RegisterController;

/* Authentication Routes */

Route::post('/register', RegisterController::class);
Route::post('/login', LoginController::class);
Route::post('/logout', LogoutController::class);

// Admin Routes
Route::group(['middleware' => ['jwt.auth', 'role:admin']], function () {
    // Posts Routes
    Route::post('/posts', [PostsController::class, 'store']);
    Route::put('/posts/{id}', [PostsController::class, 'update']);
    Route::delete('/posts/{id}', [PostsController::class, 'destroy']);
    Route::get('/posts/admin', [PostsController::class, 'index']);

    // Categories Routes
    Route::post('/categories', CategoriesController::class . '@store');
    Route::put('/categories/{id}', CategoriesController::class . '@update');
    Route::delete('/categories/{id}', CategoriesController::class . '@destroy');
    Route::get('/categories/admin', CategoriesController::class . '@index');

    // Tags Routes
    Route::post('/tags', TagsController::class . '@store');
    Route::put('/tags/{id}', TagsController::class . '@update');
    Route::delete('/tags/{id}', TagsController::class . '@destroy');
    Route::get('/tags/admin', TagsController::class . '@index');
});


// Public Routes

// Posts Routes
Route::get('/posts', [PostsController::class, 'listForPublic']);
Route::get('/posts/{slug}', [PostsController::class, 'showDetailedSlug']);

// Categories Routes
Route::get('/categories', CategoriesController::class . '@getActiveCategories');

// Tags Routes
Route::get('/tags', TagsController::class . '@getActiveTags');
