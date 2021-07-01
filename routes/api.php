<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{DonorController , RoleController , PermissionController, ActivityController}; 

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

    Route::post('/profile', [ProfileController::class, 'updateInfo']);
    Route::post('/profile/password', [ProfileController::class, 'changePassword']);

    Route::get('/users', [UserController::class, 'list']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);
    Route::get('/users/{id}/roles', [UserController::class, 'listRoles']);
    Route::post('/users/{user_id}/assign_roles', [UserController::class, 'assignRoles']);
    Route::post('/users/{user_id}/unassign_role', [UserController::class, 'unassignRole']);
    Route::get('/users/{id}/permissions', [UserController::class, 'listPermissions']);
    Route::post('/users/{id}/assign_permissions', [UserController::class, 'assignPermissions']);
    Route::post('/users/{id}/unassign_permission', [UserController::class, 'unassignPermission']);
    Route::get('/users/{user}/activity_logs', [UserController::class, 'listActivityLogs']);
    Route::get('/users/{user}/activities', [UserController::class, 'listActivities']);

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);
    Route::get('/donors/{donor}/activity_logs', [DonorController::class, 'listActivityLogs']);


    /////////////////////// Roles /////////////////////////

    Route::get('/roles', [RoleController::class, 'list']);
    Route::post('/roles', [RoleController::class, 'create']);
    Route::put('/roles', [RoleController::class, 'update']);
    Route::get('/roles/search', [RoleController::class, 'search']);
    Route::get('/roles/{id}', [RoleController::class, 'retrieve']);
    Route::get('/roles/{id}/permissions', [RoleController::class, 'listPermissions']);
    Route::post('/roles/{role}/unassign', [RoleController::class, 'unassignPermissions']);
    Route::post('/roles/{role}/assign', [RoleController::class, 'assignPermissions']);

    /////////////////////// Permission /////////////////////////

    Route::get('/permissions', [PermissionController::class, 'list']);
    Route::post('/permissions', [PermissionController::class, 'create']);
    Route::put('/permissions', [PermissionController::class, 'update']);
    Route::get('/permissions/search', [PermissionController::class, 'search']);
    Route::get('/permissions/{id}', [PermissionController::class, 'retrieve']);
    
    /////////////////////// Activity /////////////////////////

    Route::get('/activities', [ActivityController::class, 'list']);
    Route::post('/activities', [ActivityController::class, 'create']);
    Route::put('/activities', [ActivityController::class, 'update']);
    Route::get('/activities/{id}', [ActivityController::class, 'retrieve']);
    

});
