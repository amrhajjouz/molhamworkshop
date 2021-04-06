<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\{UserController, CountryController, CategoryController, SectionController, PlaceController , AdminController};
use App\Http\Controllers\Target\{
    CaseController,
    CampaignController,
    SponsorshipController,
    StudentController,
    EventController,
    FundraiserController ,
    SponsorController

};

use App\Http\Controllers\DonorController;

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
    Route::get('/users/search', [UserController::class, 'search']);
    Route::post('/users', [UserController::class, 'create']);
    Route::put('/users', [UserController::class, 'update']);
    Route::get('/users/{id}', [UserController::class, 'retrieve']);
    
    ////////////////// COUNTRY //////////////
    Route::get('/countries', [CountryController::class, 'list']);

    ////////////////// Section //////////////
    Route::get('/sections', [SectionController::class, 'list']);

    /////////////////////// Places /////////////////////////

    Route::get('/places', [PlaceController::class, 'list']);
    Route::post('/places', [PlaceController::class, 'create']);
    Route::put('/places', [PlaceController::class, 'update']);
    Route::get('/places/search', [PlaceController::class, 'search']);
    Route::get('/places/{id}', [PlaceController::class, 'retrieve']);

    ////////////////// CATEGORY //////////////
    Route::get('/categories', [CategoryController::class, 'list']);

    //////////////////CASES //////////////
    Route::get('/cases', [CaseController::class, 'list']);
    Route::post('/cases', [CaseController::class, 'create']);
    Route::put('/cases', [CaseController::class, 'update']);
    Route::get('/cases/{id}', [CaseController::class, 'retrieve']);
    Route::get('/cases/{id}/admins', [CaseController::class, 'list_admins']);
    Route::get('/cases/{id}/contents', [CaseController::class, 'list_contents']);
    Route::put('/cases/{id}/contents', [CaseController::class, 'create_update_contents']);


    //////////////////  CAMPAIGNS //////////////
    Route::get('/campaigns', [CampaignController::class, 'list']);
    Route::post('/campaigns', [CampaignController::class, 'create']);
    Route::put('/campaigns', [CampaignController::class, 'update']);
    Route::get('/campaigns/{id}', [CampaignController::class, 'retrieve']);
    Route::get('/campaigns/{id}/contents', [CampaignController::class, 'list_contents']);
    Route::put('/campaigns/{id}/contents', [CampaignController::class, 'create_update_contents']);

    //////////////////  SponsorShips //////////////
    Route::get('/sponsorships', [SponsorshipController::class, 'list']);
    Route::post('/sponsorships', [SponsorshipController::class, 'create']);
    Route::put('/sponsorships', [SponsorshipController::class, 'update']);
    Route::get('/sponsorships/{id}', [SponsorshipController::class, 'retrieve']);
    Route::get('/sponsorships/{id}/sponsors', [SponsorshipController::class, 'list_sponsors']);
    Route::get('/sponsorships/{id}/contents', [SponsorshipController::class, 'list_contents']);
    Route::put('/sponsorships/{id}/contents', [SponsorshipController::class, 'create_update_contents']);

    //////////////////  Students //////////////
    Route::get('/students', [StudentController::class, 'list']);
    Route::post('/students', [StudentController::class, 'create']);
    Route::put('/students', [StudentController::class, 'update']);
    Route::get('/students/{id}', [StudentController::class, 'retrieve']);
    Route::get('/students/{id}/sponsors', [StudentController::class, 'list_sponsors']);
    Route::get('/students/{id}/contents', [StudentController::class, 'list_contents']);
    Route::put('/students/{id}/contents', [StudentController::class, 'create_update_contents']);

    //////////////////  Events //////////////
    Route::get('/events', [EventController::class, 'list']);
    Route::post('/events', [EventController::class, 'create']);
    Route::put('/events', [EventController::class, 'update']);
    Route::get('/events/{id}', [EventController::class, 'retrieve']);
    Route::get('/events/{id}/contents', [EventController::class, 'list_contents']);
    Route::put('/events/{id}/contents', [EventController::class, 'create_update_contents']);

    ////////////////// Fundraiser // //////////////
    Route::get('/fundraisers', [FundraiserController::class, 'list']);
    Route::post('/fundraisers', [FundraiserController::class, 'create']);
    Route::put('/fundraisers', [FundraiserController::class, 'update']);
    Route::get('/fundraisers/{id}', [FundraiserController::class, 'retrieve']);
    Route::get('/fundraisers/{id}/contents', [FundraiserController::class, 'list_contents']);
    Route::put('/fundraisers/{id}/contents', [FundraiserController::class, 'create_update_contents']);


    /////////////////////// Donors /////////////////////////

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/search', [DonorController::class, 'search']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);


    /////////////////////// Sponsors /////////////////////////

    Route::post('/sponsors', [SponsorController::class, 'create']);
    Route::put('/sponsors', [SponsorController::class, 'update']);

    /////////////////////// AdminController /////////////////////////

    // Route::post('/admins', [AdminController::class, 'create']);
    // Route::put('/admins', [AdminController::class, 'update']);
    // Route::post('/admins/delete', [AdminController::class, 'delete']);
});




// lists (s)
// overview(single)
// create (single)
// edit ()
// 
// 