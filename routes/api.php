<?php

use App\Http\Controllers\PostCommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserRoleController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('users', [UserController::class, 'store']);
Route::post('login', [UserController::class, 'login']);
Route::apiResource('users', UserController::class)->except(['edit', 'create', 'store', 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin']);
Route::put('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::post('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::patch('users/{user}', [UserController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::get('me', [UserController::class, 'me'])->middleware('auth:sanctum');

Route::apiResource('roles', RoleController::class)->except(['create', 'edit'])->middleware(['auth:sanctum', 'ability:admin,super-admin,user']);
Route::apiResource('users.roles', UserRoleController::class)->except(['create', 'edit', 'show', 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin']);

Route::post('posts', [PostController::class, 'store'])->middleware(['auth:sanctum', 'ability:admin,super-admin,editor']);
Route::get('posts', [PostController::class, 'index'])->middleware(['auth:sanctum']);
Route::get('posts/{post}', [PostController::class, 'show'])->middleware(['auth:sanctum']);
Route::put('posts/{post}', [PostController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,editor']);
Route::delete('posts/{post}', [PostController::class, 'update'])->middleware(['auth:sanctum', 'ability:admin,super-admin,editor']);

Route::apiResource('posts.comments', PostCommentController::class)->middleware(['auth:sanctum']);
