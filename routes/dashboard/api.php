<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\{CountryController, CategoryController};
use App\Http\Controllers\Dashboard\Media\SocialMediaPost\SocialMediaPostController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\Program\Medical\{CaseController};

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

Route::middleware('auth')->group(function () {

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

    //Country Routes
    Route::get('/countries', [CountryController::class, 'list']);

    // Place Routes
    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    // Country Routes
    Route::get('/countries', [CountryController::class, 'list']);
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Cases Routes
    Route::get('/programs/medical/cases', [CaseController::class, 'list']);
    Route::post('/programs/medical/cases', [CaseController::class, 'create']);
    Route::put('/programs/medical/cases', [CaseController::class, 'update']);
    Route::get('/programs/medical/cases/{id}', [CaseController::class, 'retrieve']);
    Route::post('/programs/medical/cases/{id}/hide', [CaseController::class, 'markAsHidden']);
    Route::post('/programs/medical/cases/{id}/unhide', [CaseController::class, 'markAsVisible']);
    Route::post('/programs/medical/cases/{id}/archive', [CaseController::class, 'markAsArchived']);
    Route::post('/programs/medical/cases/{id}/unarchive', [CaseController::class, 'markAsUnarchived']);
    Route::post('/programs/medical/cases/{id}/document', [CaseController::class, 'markAsDocumented']);
    Route::post('/programs/medical/cases/{id}/undocument', [CaseController::class, 'markAsUndocumented']);
    Route::post('/programs/medical/cases/{id}/ready_to_publish', [CaseController::class, 'markAsReadyToPublish']);
    Route::put('/programs/medical/cases/{id}/contents', [CaseController::class, 'updateCaseContents']);

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


    Route::group(['namespace' => 'App\Http\Controllers\Dashboard',], function () {
        //Translation -> Cases
        Route::get('/translation/cases' , 'Translation\CaseController@list');
        Route::get('/translation/cases/{id}' , 'Translation\CaseController@retrieve');
        Route::put('/translation/cases' , 'Translation\CaseController@update');
        Route::post('/translation/cases/{id}/proofread' , 'Translation\CaseController@markAsProofread');
        
        //Translation -> SocialMedia
        Route::get('/translation/social_media_posts' , 'Translation\TranslationSocialMediaPostController@list');
        Route::get('/translation/social_media_posts/{id}' , 'Translation\TranslationSocialMediaPostController@retrieve');
        Route::put('/translation/social_media_posts' , 'Translation\TranslationSocialMediaPostController@update');
        Route::post('/translation/social_media_posts/{id}/proofread' , 'Translation\TranslationSocialMediaPostController@markAsProofread');
       
        //Publishing -> Cases
        Route::get('/publishing/cases' , 'Publishing\CaseController@list');
        Route::get('/publishing/cases/{id}' , 'Publishing\CaseController@retrieve');
        Route::put('/publishing/cases' , 'Publishing\CaseController@update');
        Route::post('/publishing/cases/{id}/publish' , 'Publishing\CaseController@markAsPublished');
        Route::post('/publishing/cases/{id}/proofread' , 'Publishing\CaseController@markAsProofread');
    });

});
