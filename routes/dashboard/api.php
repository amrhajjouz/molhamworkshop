<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\Media\SocialMediaPost\SocialMediaPostController;

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
    Route::get('/users/{id}', [UserController::class, 'retrieve']);
    
    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);

    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Media Routes
    Route::get('/media/social_media_posts', [SocialMediaPostController::class, 'list']);
    Route::post('/media/social_media_posts', [SocialMediaPostController::class, 'create']);
    Route::put('/media/social_media_posts', [SocialMediaPostController::class, 'update']);
    Route::get('/media/social_media_posts/{id}', [SocialMediaPostController::class, 'retrieve']);
    Route::post('/media/social_media_posts/{id}/proofread', [SocialMediaPostController::class, 'markAsProofread']);
    Route::post('/media/social_media_posts/{id}/approve', [SocialMediaPostController::class, 'markAsApproved']);
    Route::post('/media/social_media_posts/{id}/reject', [SocialMediaPostController::class, 'markAsRejected']);
    Route::post('/media/social_media_posts/{id}/archive', [SocialMediaPostController::class, 'markAsArchived']);
    Route::put('/media/social_media_posts/{id}/publishing', [SocialMediaPostController::class, 'updateSocialMediaPostPublishingOptions']);
    Route::get('/media/social_media_posts/{id}/images', [SocialMediaPostController::class, 'listSocialMediaPostImages']);
    Route::post('/media/social_media_posts/{id}/images', [SocialMediaPostController::class, 'createSocialMediaPostImage']);
    Route::delete('/media/social_media_posts/{id}/images/{image_id}', [SocialMediaPostController::class, 'deleteSocialMediaPostImage']);
    Route::post('/media/social_media_posts/{id}/images/download', [SocialMediaPostController::class, 'downloadImages']);

    Route::group(['namespace' => 'App\Http\Controllers\Dashboard',], function () {
        //Translation -> SocialMedia
        Route::get('/translation/social_media_posts' , 'Translation\TranslationSocialMediaPostController@list');
        Route::get('/translation/social_media_posts/{id}' , 'Translation\TranslationSocialMediaPostController@retrieve');
        Route::put('/translation/social_media_posts' , 'Translation\TranslationSocialMediaPostController@update');
        Route::post('/translation/social_media_posts/{id}/proofread' , 'Translation\TranslationSocialMediaPostController@markAsProofread');
    });

});
