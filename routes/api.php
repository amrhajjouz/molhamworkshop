<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\ProfileController;



/////////////////////// Target Controller /////////////////////////

use App\Http\Controllers\Target\{
    CaseController,
    CampaignController,
    SponsorshipController,
    StudentController,
    EventController,
    FundraiserController,
    SponsorController
};




use App\Http\Controllers\{
    UserController,
    CountryController,
    CategoryController,
    SectionController,
    PlaceController,
    ConstantController,
    FaqController ,
    ShortcutController,
    PageController,
    BlogController,
    PublisherController,
    ShortcutKeyController,
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
    Route::get('/cases/{case}/contents', [CaseController::class, 'list_contents']);
    Route::put('/cases/{case}/contents', [CaseController::class, 'create_update_contents']);


    //////////////////  CAMPAIGNS //////////////
    Route::get('/campaigns', [CampaignController::class, 'list']);
    Route::post('/campaigns', [CampaignController::class, 'create']);
    Route::put('/campaigns', [CampaignController::class, 'update']);
    Route::get('/campaigns/{id}', [CampaignController::class, 'retrieve']);
    Route::get('/campaigns/{campaign}/contents', [CampaignController::class, 'list_contents']);
    Route::put('/campaigns/{campaign}/contents', [CampaignController::class, 'create_update_contents']);

    //////////////////  SponsorShips //////////////
    Route::get('/sponsorships', [SponsorshipController::class, 'list']);
    Route::post('/sponsorships', [SponsorshipController::class, 'create']);
    Route::put('/sponsorships', [SponsorshipController::class, 'update']);
    Route::get('/sponsorships/{id}', [SponsorshipController::class, 'retrieve']);
    Route::get('/sponsorships/{id}/sponsors', [SponsorshipController::class, 'list_sponsors']);
    Route::get('/sponsorships/{sponsorship}/contents', [SponsorshipController::class, 'list_contents']);
    Route::put('/sponsorships/{sponsorship}/contents', [SponsorshipController::class, 'create_update_contents']);

    //////////////////  Students //////////////
    Route::get('/students', [StudentController::class, 'list']);
    Route::post('/students', [StudentController::class, 'create']);
    Route::put('/students', [StudentController::class, 'update']);
    Route::get('/students/{id}', [StudentController::class, 'retrieve']);
    Route::get('/students/{id}/sponsors', [StudentController::class, 'list_sponsors']);
    Route::get('/students/{student}/contents', [StudentController::class, 'list_contents']);
    Route::put('/students/{student}/contents', [StudentController::class, 'create_update_contents']);

    //////////////////  Events //////////////
    Route::get('/events', [EventController::class, 'list']);
    Route::post('/events', [EventController::class, 'create']);
    Route::put('/events', [EventController::class, 'update']);
    Route::get('/events/{id}', [EventController::class, 'retrieve']);
    Route::get('/events/{event}/contents', [EventController::class, 'list_contents']);
    Route::put('/events/{event}/contents', [EventController::class, 'create_update_contents']);

    ////////////////// Fundraiser // //////////////
    Route::get('/fundraisers', [FundraiserController::class, 'list']);
    Route::post('/fundraisers', [FundraiserController::class, 'create']);
    Route::put('/fundraisers', [FundraiserController::class, 'update']);
    Route::get('/fundraisers/{id}', [FundraiserController::class, 'retrieve']);
    Route::get('/fundraisers/{fundraiser}/contents', [FundraiserController::class, 'list_contents']);
    Route::put('/fundraisers/{fundraiser}/contents', [FundraiserController::class, 'create_update_contents']);


    /////////////////////// Donors /////////////////////////

    Route::get('/donors', [DonorController::class, 'list']);
    Route::post('/donors', [DonorController::class, 'create']);
    Route::put('/donors', [DonorController::class, 'update']);
    Route::get('/donors/search', [DonorController::class, 'search']);
    Route::get('/donors/{id}', [DonorController::class, 'retrieve']);


    /////////////////////// Sponsors /////////////////////////

    Route::post('/sponsors', [SponsorController::class, 'create']);
    Route::put('/sponsors', [SponsorController::class, 'update']);


    ////////////////// Constants // //////////////
    Route::get('/constants', [ConstantController::class, 'list']);
    Route::post('/constants', [ConstantController::class, 'create']);
    Route::put('/constants', [ConstantController::class, 'update']);
    Route::get('/constants/{id}', [ConstantController::class, 'retrieve']);
    Route::put('/constants/{constant}/contents', [ConstantController::class, 'create_update_contents']);

    ////////////////// Faq /////////////////

    Route::get('/faqs', [FaqController::class, 'list']);
    Route::post('/faqs', [FaqController::class, 'create']);
    Route::put('/faqs', [FaqController::class, 'update']);
    Route::get('/faqs/{id}', [FaqController::class, 'retrieve']);
    // Route::get('/faqs/{faq}/contents', [FaqController::class, 'list_contents']);
    Route::put('/faqs/{faq}/contents', [FaqController::class, 'create_update_contents']);
  
  
    ////////////////// Shortcut /////////////////
    Route::get('/shortcuts', [ShortcutController::class, 'list']);
    Route::post('/shortcuts', [ShortcutController::class, 'create']);
    Route::put('/shortcuts', [ShortcutController::class, 'update']);
    Route::get('/shortcuts/{id}', [ShortcutController::class, 'retrieve']);
    Route::get('/shortcuts/{id}/keys', [ShortcutController::class, 'list_keys']);
    Route::put('/shortcuts/{shortcut}/contents', [ShortcutController::class, 'create_update_contents']);


    ////////////////// Shortcut Keys /////////////////
    Route::post('/shortcuts_keys/{shortcut_id}', [ShortcutKeyController::class, 'create']);
    Route::put('/shortcuts_keys/{shortcut_key}/contents', [ShortcutKeyController::class, 'create_update_contents']);


    /////////////////////// Pages /////////////////////////
    Route::get('/pages', [PageController::class, 'list']);
    Route::post('/pages', [PageController::class, 'create']);
    Route::put('/pages', [PageController::class, 'update']);
    Route::get('/pages/{id}', [PageController::class, 'retrieve']);
    Route::put('/pages/{page}/contents', [PageController::class, 'create_update_contents']);

    /////////////////////// Blogs /////////////////////////
    Route::get('/blogs', [BlogController::class, 'list']);
    Route::post('/blogs', [BlogController::class, 'create']);
    Route::put('/blogs', [BlogController::class, 'update']);
    Route::get('/blogs/{id}', [BlogController::class, 'retrieve']);
    Route::put('/blogs/{blog}/contents', [BlogController::class, 'create_update_contents']);

    /////////////////////// Publisher /////////////////////////
    Route::get('/publishers', [PublisherController::class, 'list']);
    Route::post('/publishers', [PublisherController::class, 'create']);
    Route::get('/publishers/{id}', [PublisherController::class, 'retrieve']);
    Route::put('/publishers/{publisher}/contents', [PublisherController::class, 'create_update_contents']);



});




// lists (s)
// overview(single)
// create (single)
// edit ()
// 
// 