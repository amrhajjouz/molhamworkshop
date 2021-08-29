<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DonorController , RoleController , PermissionController  , SectionController, TitleController}; 

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

Route::middleware('auth')->group(function ()  {

    Route::get('/auth', function (Request $request) {
        return $request->user();
    });

    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/search', [UserController::class, 'search']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);
    Route::get('/users/{id}/roles', [UserController::class, 'list_roles']);
    Route::post('/users/{user_id}/assign_roles', [UserController::class, 'assign_roles']);
    Route::post('/users/{user_id}/unassign_role', [UserController::class, 'unassign_role']);
    Route::get('/users/{id}/permissions', [UserController::class, 'list_permissions']);
    Route::post('/users/{id}/assign_permissions', [UserController::class, 'assign_permissions']);
    Route::post('/users/{id}/unassign_permission', [UserController::class, 'unassign_permission']);
    ///////////////////// Donors /////////////////////
    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);
    /////////////////////// Roles /////////////////////////
    Route::get('/roles', [RoleController::class, 'list']);
    Route::post('/roles', [RoleController::class, 'create']);
    Route::put('/roles', [RoleController::class, 'update']);
    Route::get('/roles/search', [RoleController::class, 'search']);
    Route::get('/roles/{id}', [RoleController::class, 'retrieve']);
    Route::get('/roles/{id}/permissions', [RoleController::class, 'list_permissions']);
    Route::post('/roles/{role}/unassign', [RoleController::class, 'unassign_permissions']);
    Route::post('/roles/{role}/assign', [RoleController::class, 'assign_permissions']);
    /////////////////////// Permission /////////////////////////
    Route::get('/permissions', [PermissionController::class, 'list']);
    Route::post('/permissions', [PermissionController::class, 'create']);
    Route::put('/permissions', [PermissionController::class, 'update']);
    Route::get('/permissions/search', [PermissionController::class, 'search']);
    Route::get('/permissions/{id}', [PermissionController::class, 'retrieve']);
    ///////////////////// Sections /////////////////////
    Route::get('/sections', [SectionController::class, 'list']);
    Route::post('/sections', [SectionController::class, 'create']);
    Route::put('/sections', [SectionController::class, 'update']);
    Route::get('/sections/search', [SectionController::class, 'search']);
    Route::get('/sections/{id}', [SectionController::class, 'retrieve']);
    ///////////////////// title /////////////////////
    Route::get('/titles/search', [TitleController::class, 'search']);

});
