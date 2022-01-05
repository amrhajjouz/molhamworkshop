<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Dashboard\ProfileController;
use App\Http\Controllers\Dashboard\UserController;
use App\Http\Controllers\Dashboard\DonorController;
use App\Http\Controllers\Dashboard\PlaceController;
use App\Http\Controllers\Dashboard\CountryController;
use App\Http\Controllers\Dashboard\MemberController;
use App\Http\Controllers\Dashboard\LoanRequestController;
use App\Http\Controllers\Dashboard\AdvancePaymentRequestController;
use App\Http\Controllers\Dashboard\TravelRequestController;
use App\Http\Controllers\Dashboard\UserFamilyMemberController;
use App\Http\Controllers\Dashboard\UserContractController;
use App\Http\Controllers\Dashboard\UserSectionController;
use App\Http\Controllers\Dashboard\UserWorkExperienceController;
use App\Http\Controllers\Dashboard\UserSkillController;
use App\Http\Controllers\Dashboard\TeamOfficeController;
use App\Http\Controllers\Dashboard\JobTitleController;
use App\Http\Controllers\Dashboard\LeaveController;
use App\Http\Controllers\Dashboard\LeaveTypeController;
use App\Http\Controllers\Dashboard\UserLanguageController;
use App\Http\Controllers\Dashboard\UserTrainingController;

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

    // Place Routes
    Route::get('/places/search', [PlaceController::class, 'search']);

    // Country Routes
    Route::get('/countries/search', [CountryController::class, 'search']);

    // Member Routes
    Route::get('/members', [MemberController::class, 'list']);
    Route::get('/members/leaves', [LeaveController::class, 'leaves']);
    Route::get('/members/leaves/{id}', [LeaveController::class, 'show']);
    Route::put('/members/leaves', [LeaveController::class, 'status_update']);
    Route::post('/members', [MemberController::class, 'create']);
    Route::put('/members', [MemberController::class, 'update']);
    Route::get('/members/search', [MemberController::class, 'search']);
    Route::get('/members/user_sections', [MemberController::class, 'user_sections']);
    Route::get('/members/{id}', [MemberController::class, 'retrieve']);
    Route::get('/members/contracts/{id}', [MemberController::class, 'contracts']);
    Route::get('/members/user_family_member/{id}', [MemberController::class, 'user_family_member']);
    Route::get('/members/user_work_experiences/{id}', [MemberController::class, 'user_work_experiences']);
    Route::get('/members/user_skills/{id}', [MemberController::class, 'user_skills']);
    Route::get('/members/user_languages/{id}', [MemberController::class, 'user_languages']);
    Route::get('/members/user_trainings/{id}', [MemberController::class, 'user_trainings']);
    Route::get('/members/info/{id}', [MemberController::class, 'info']);
    Route::delete('/members/{id}', [MemberController::class, 'delete']);

    // User Contracts Routes
    Route::get('/user_contracts', [UserContractController::class, 'list']);
    Route::post('/user_contracts/{id}', [UserContractController::class, 'create']);
    Route::put('/user_contracts', [UserContractController::class, 'update']);
    Route::get('/user_contracts/search', [UserContractController::class, 'search']);
    Route::get('/user_contracts/members', [UserContractController::class, 'members']);
    Route::get('/user_contracts/{id}', [UserContractController::class, 'retrieve']);
    Route::delete('/user_contracts/{id}', [UserContractController::class, 'delete']);

    // User Sections Routes
    Route::get('/user_sections', [UserSectionController::class, 'list']);
    Route::post('/user_sections', [UserSectionController::class, 'create']);
    Route::put('/user_sections', [UserSectionController::class, 'update']);
    Route::get('/user_sections/search', [UserSectionController::class, 'search']);
    Route::get('/user_sections/{id}', [UserSectionController::class, 'retrieve']);
    Route::delete('/user_sections/{id}', [UserSectionController::class, 'delete']);

    // Team Offices Routes
    Route::get('/team_offices', [TeamOfficeController::class, 'list']);
    Route::post('/team_offices', [TeamOfficeController::class, 'create']);
    Route::put('/team_offices', [TeamOfficeController::class, 'update']);
    Route::get('/team_offices/search', [TeamOfficeController::class, 'search']);
    Route::get('/team_offices/{id}', [TeamOfficeController::class, 'retrieve']);
    Route::delete('/team_offices/{id}', [TeamOfficeController::class, 'delete']);

    // Job Titles Routes
    Route::get('/job_titles', [JobTitleController::class, 'list']);
    Route::post('/job_titles', [JobTitleController::class, 'create']);
    Route::put('/job_titles', [JobTitleController::class, 'update']);
    Route::get('/job_titles/search', [JobTitleController::class, 'search']);
    Route::get('/job_titles/{id}', [JobTitleController::class, 'retrieve']);
    Route::delete('/job_titles/{id}', [JobTitleController::class, 'delete']);

    // Loan Requests Routes
    Route::get('/loan_requests', [LoanRequestController::class, 'list']);
    Route::post('/loan_requests', [LoanRequestController::class, 'create']);
    Route::put('/loan_requests', [LoanRequestController::class, 'update']);
    Route::get('/loan_requests/search', [LoanRequestController::class, 'search']);
    Route::get('/loan_requests/{id}', [LoanRequestController::class, 'retrieve']);
    Route::delete('/loan_requests/{id}', [LoanRequestController::class, 'delete']);

    // Advance Payment Request Routes
    Route::get('/advance_payment_requests', [AdvancePaymentRequestController::class, 'list']);
    Route::post('/advance_payment_requests', [AdvancePaymentRequestController::class, 'create']);
    Route::put('/advance_payment_requests', [AdvancePaymentRequestController::class, 'update']);
    Route::get('/advance_payment_requests/search', [AdvancePaymentRequestController::class, 'search']);
    Route::get('/advance_payment_requests/{id}', [AdvancePaymentRequestController::class, 'retrieve']);
    Route::delete('/advance_payment_requests/{id}', [AdvancePaymentRequestController::class, 'delete']);

    // Travel Requests Routes
    Route::get('/travel_requests', [TravelRequestController::class, 'list']);
    Route::post('/travel_requests', [TravelRequestController::class, 'create']);
    Route::put('/travel_requests', [TravelRequestController::class, 'update']);
    Route::get('/travel_requests/search', [TravelRequestController::class, 'search']);
    Route::get('/travel_requests/{id}', [TravelRequestController::class, 'retrieve']);
    Route::delete('/travel_requests/{id}', [TravelRequestController::class, 'delete']);


    // profile Routes
    Route::post('/profile', [ProfileController::class, 'update_info']);
    Route::post('/profile/password', [ProfileController::class, 'change_password']);
    Route::post('/profile/employment_data', [ProfileController::class, 'employment_data']);
    Route::post('/profile/residence_data', [ProfileController::class, 'residence_data']);
    Route::post('/profile/contact_data', [ProfileController::class, 'contact_data']);
    Route::post('/profile/experiences_and_skills', [ProfileController::class, 'experiences_and_skills']);
    Route::post('/profile/additional_data', [ProfileController::class, 'additional_data']);
    Route::post('/profile/education', [ProfileController::class, 'education']);
    Route::get('/profile/contracts', [ProfileController::class, 'contracts']);

    // User Family Members Routes
    Route::get('/user_family_members', [UserFamilyMemberController::class, 'list']);
    Route::post('/user_family_members', [UserFamilyMemberController::class, 'create']);
    Route::put('/user_family_members', [UserFamilyMemberController::class, 'update']);
    Route::get('/user_family_members/search', [UserFamilyMemberController::class, 'search']);
    Route::get('/user_family_members/{id}', [UserFamilyMemberController::class, 'retrieve']);
    Route::delete('/user_family_members/{id}', [UserFamilyMemberController::class, 'delete']);

    // User Work Experience Routes
    Route::get('/user_work_experiences', [UserWorkExperienceController::class, 'list']);
    Route::post('/user_work_experiences', [UserWorkExperienceController::class, 'create']);
    Route::put('/user_work_experiences', [UserWorkExperienceController::class, 'update']);
    Route::get('/user_work_experiences/search', [UserWorkExperienceController::class, 'search']);
    Route::get('/user_work_experiences/{id}', [UserWorkExperienceController::class, 'retrieve']);
    Route::delete('/user_work_experiences/{id}', [UserWorkExperienceController::class, 'delete']);

    // User Skills Routes
    Route::get('/user_skills', [UserSkillController::class, 'list']);
    Route::post('/user_skills', [UserSkillController::class, 'create']);
    Route::put('/user_skills', [UserSkillController::class, 'update']);
    Route::get('/user_skills/search', [UserSkillController::class, 'search']);
    Route::get('/user_skills/{id}', [UserSkillController::class, 'retrieve']);
    Route::delete('/user_skills/{id}', [UserSkillController::class, 'delete']);
    
    // Leave Types Routes
    Route::get('/leave_types', [LeaveTypeController::class, 'list']);
    Route::post('/leave_types', [LeaveTypeController::class, 'create']);
    Route::put('/leave_types', [LeaveTypeController::class, 'update']);
    Route::get('/leave_types/search', [LeaveTypeController::class, 'search']);
    Route::get('/leave_types/{id}', [LeaveTypeController::class, 'retrieve']);
    Route::delete('/leave_types/{id}', [LeaveTypeController::class, 'delete']);

    // Leave Routes
    Route::get('/leaves', [LeaveController::class, 'list']);
    Route::post('/leaves', [LeaveController::class, 'create']);
    Route::put('/leaves', [LeaveController::class, 'update']);
    Route::get('/leaves/search', [LeaveController::class, 'search']);
    Route::get('/leaves/user_sections', [LeaveController::class, 'user_sections']);
    Route::get('/leaves/{id}', [LeaveController::class, 'retrieve']);
    Route::get('/leaves/contracts/{id}', [LeaveController::class, 'contracts']);
    Route::delete('/leaves/{id}', [LeaveController::class, 'delete']);

    // User Languages Routes
    Route::get('/user_languages', [UserLanguageController::class, 'list']);
    Route::post('/user_languages', [UserLanguageController::class, 'create']);
    Route::put('/user_languages', [UserLanguageController::class, 'update']);
    Route::get('/user_languages/search', [UserLanguageController::class, 'search']);
    Route::get('/user_languages/{id}', [UserLanguageController::class, 'retrieve']);
    Route::delete('/user_languages/{id}', [UserLanguageController::class, 'delete']);

    // User Trainings Routes
    Route::get('/user_trainings', [UserTrainingController::class, 'list']);
    Route::post('/user_trainings', [UserTrainingController::class, 'create']);
    Route::put('/user_trainings', [UserTrainingController::class, 'update']);
    Route::get('/user_trainings/search', [UserTrainingController::class, 'search']);
    Route::get('/user_trainings/{id}', [UserTrainingController::class, 'retrieve']);
    Route::delete('/user_trainings/{id}', [UserTrainingController::class, 'delete']);
});
