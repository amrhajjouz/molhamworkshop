<?php

use Illuminate\Http\Request;
use App\Http\Controllers\Auth\ProfileController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\{DonorController , AuthDonorController , FeedbackController, PaymentMethodController, SubscriptionController , ReviewController , SavedItemController , CartItemController};
use App\Http\Controllers\Api\PaymentProvider\Stripe\{SetupIntentController};
use App\Http\Controllers\Api\Targetable\{CaseController , CampaignController , FundraiserController , EventController , ScholarshipController , SponsorshipController , ProjectController , SmallProjectController};
use App\Http\Controllers\Api\{LikeController , CommentController};

//use Stripe\StripeClient;

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

Route::get('/test', function () {    
    
    return listDummyTargetables('cases', 10);
    
    $cardExistsForAuth = false;
    return \App\Models\StripeCard::with('paymentMethod')->where('fingerprint', 'HYumAOu91ekiPONh')->get();
    foreach (\App\Models\StripeCard::with('paymentMethod')->where('fingerprint', 'HYumAOu91ekiPONh')->get() as $c) {
        return $c->paymentMethod;
        if ($c->paymentMethod->donor_id == 3)
            $cardExistsForAuth = true;
    }
    
    return $cardExistsForAuth;
    /*return \App\Models\SwishAccount::find(1)->paymentMethod;
    return createRandomPaymentMethods(4);
    $stripe = new StripeClient('sk_test_rWaVeJAcQYStJcShQeoxWUHg005redZKzG');
    try {
        //return $stripe->setupIntents->retrieve('seti_1JPM9M2eZvKYlo2CH4ji1fNNs');
        //return $stripe->paymentMethods->attach('pm_1JRxZlHChY2eOuBQu02dRkqW', ['customer' => 'cus_K67XXPDN5B09pD']);
        return $stripe->paymentMethods->retrieve('pm_1JRyKCHChY2eOuBQBsFciHsd', []);

        return $stripe->paymentMethods->create([
            'type' => 'card',
            'card' => [
                'number' => '4242424242424242',
                'exp_month' => 8,
                'exp_year' => 2022,
                'cvc' => '314',
            ],
        ]);
    } catch (\Exception $e) {
        return $e;
    }*/
});

Route::group(['middleware' => 'auth_donor:optional'], function () {
    Route::post('/donors/authenticate' , [DonorController::class, 'authenticate'])->name('api.donors.authenticate');
    Route::post('/donors' , [DonorController::class, 'create'])->name('api.donors.create');
    Route::post('/donors/reset_password' , [DonorController::class, 'createResetPasswordRequest'])->name('api.donors.reset_password_request.create'); 
    Route::post('/donors/reset_password/{token}' , [DonorController::class, 'retrieveResetPasswordRequest'])->name('api.donors.reset_password_request.retrieve'); 
    Route::post('/donors/reset_password/{token}/confirm' , [DonorController::class, 'confirmResetPasswordRequest'])->name('api.donors.reset_password_request.confirm'); 
    Route::post('/donors/verify_email' , [DonorController::class, 'verifyEmail'])->name('api.donors.verify_email'); 
    Route::get('/reviews' , [ReviewController::class, 'list'])->name('api.reviews.list'); 
    
    //Cases
    Route::get('/targetables/cases' , [CaseController::class, 'list'])->name('api.cases.list'); 
    Route::get('/targetables/cases/{id}' , [CaseController::class, 'retrieve'])->name('api.cases.retrieve');

       
    //Campaigns
    Route::get('/targetables/campaigns' , [CampaignController::class, 'list'])->name('api.campaigns.list'); 
    Route::get('/targetables/campaigns/{id}' , [CampaignController::class, 'retrieve'])->name('api.campaigns.retrieve');
    
    //Fundraiser
    Route::get('/targetables/fundraisers' , [FundraiserController::class, 'list'])->name('api.fundraisers.list'); 
    Route::get('/targetables/fundraisers/{id}' , [FundraiserController::class, 'retrieve'])->name('api.fundraisers.retrieve');
    
    //Event
    Route::get('/targetables/events' , [EventController::class, 'list'])->name('api.events.list'); 
    Route::get('/targetables/events/{id}' , [EventController::class, 'retrieve'])->name('api.events.retrieve');
    
    //Scholarship
    Route::get('/targetables/scholarships' , [ScholarshipController::class, 'list'])->name('api.scholarships.list'); 
    Route::get('/targetables/scholarships/{id}' , [ScholarshipController::class, 'retrieve'])->name('api.scholarships.retrieve');
    
    //Sponsorship
    Route::get('/targetables/sponsorships' , [SponsorshipController::class, 'list'])->name('api.sponsorships.list'); 
    Route::get('/targetables/sponsorships/{id}' , [SponsorshipController::class, 'retrieve'])->name('api.sponsorships.retrieve');
   
    //Project
    Route::get('/targetables/projects' , [ProjectController::class, 'list'])->name('api.projects.list'); 
    Route::get('/targetables/projects/{id}' , [ProjectController::class, 'retrieve'])->name('api.projects.retrieve');
   
    //Small Project
    Route::get('/targetables/small_projects' , [SmallProjectController::class, 'list'])->name('api.small_projects.list'); 
    Route::get('/targetables/small_projects/{id}' , [SmallProjectController::class, 'retrieve'])->name('api.small_projects.retrieve');
    
    //Comments
    Route::get('/comments' , [CommentController::class, 'list'])->name('api.comments.list');
    // Targetables
    // Route::get('/targetables/{type}' , [TargetableController::class, 'list'])->name('api.targetables.list'); 
    // Route::get('/targetables/{type}/{id}' , [TargetableController::class, 'retrieve'])->name('api.targetables.retrieve');
    
});

Route::group(['middleware' => 'auth_donor'], function () {
// Route::group([], function () {
    Route::get('/donors/auth' , [AuthDonorController::class, 'retrieve'])->name('api.donors.auth.retrieve'); 
    Route::post('/donors/auth/logout' , [AuthDonorController::class, 'logout'])->name('api.donors.auth.logout'); 
    Route::post('/donors/auth' , [AuthDonorController::class, 'update'])->name('api.donors.auth.update'); 
    Route::post('/donors/auth/delete' , [AuthDonorController::class, 'delete'])->name('api.donors.auth.delete'); 
    Route::post('/donors/auth/email' , [AuthDonorController::class, 'changeEmail'])->name('api.donors.auth.email.change'); 
    Route::post('/donors/auth/password' , [AuthDonorController::class, 'changePassword'])->name('api.donors.auth.password.change'); 
    Route::get('/donors/auth/notification_preferences' , [AuthDonorController::class, 'listNotificationPreferences'])->name('api.donors.auth.notification_preferences.list'); 
    Route::put('/donors/auth/notification_preferences' , [AuthDonorController::class, 'updateNotificationPreferences'])->name('api.donors.auth.notification_preferences.update'); 
    Route::get('/donors/auth/payment_methods' , [AuthDonorController::class, 'listPaymentMethods'])->name('api.donors.auth.payment_methods.list'); 
    Route::post('/donors/auth/avatar' , [AuthDonorController::class, 'changeAvatar'])->name('api.donors.auth.avatar.change'); 
    Route::delete('/donors/auth/avatar' , [AuthDonorController::class, 'removeAvatar'])->name('api.donors.auth.avatar.remove'); 
    Route::get('/donors/auth/saved_items' , [AuthDonorController::class, 'listSavedItems'])->name('api.donors.auth.saved_items.list'); 
    Route::get('/donors/auth/cart_items' , [AuthDonorController::class, 'listCartItems'])->name('api.donors.auth.cart_items.list'); 
    Route::get('/donors/auth/reviews' , [AuthDonorController::class, 'listReviews'])->name('api.donors.auth.reviews.list'); 
    Route::get('/donors/auth/feedbacks' , [AuthDonorController::class, 'listFeedbacks'])->name('api.donors.auth.feedbacks.list'); 
    
    //SavedItem
    Route::post('/saved_items' , [SavedItemController::class, 'create'])->name('api.saved_items.create'); 
    Route::delete('/saved_items/{id}' , [SavedItemController::class, 'delete'])->name('api.saved_items.delete'); 
  
    //CartItem
    Route::post('/cart_items' , [CartItemController::class, 'create'])->name('api.cart_items.create'); 
    Route::delete('/cart_items/{id}' , [CartItemController::class, 'delete'])->name('api.cart_items.delete'); 
    Route::delete('/cart_items' , [CartItemController::class, 'deleteCartItems'])->name('api.cart_items.deleteCartItems'); 

     //Review
     Route::post('/reviews' , [ReviewController::class, 'create'])->name('api.reviews.create'); 
     Route::put('/reviews/{id}' , [ReviewController::class, 'update'])->name('api.reviews.update'); 
     Route::delete('/reviews/{id}' , [ReviewController::class, 'delete'])->name('api.reviews.delete'); 

      //Feedbacks
      Route::post('/feedbacks' , [FeedbackController::class, 'create'])->name('api.feedbacks.create'); 
      Route::put('/feedbacks/{id}' , [FeedbackController::class, 'update'])->name('api.feedbacks.update'); 
      Route::delete('/feedbacks/{id}' , [FeedbackController::class, 'delete'])->name('api.feedbacks.delete'); 


    //Subscriptions
    Route::post('/subscriptions' , [SubscriptionController::class, 'create'])->name('api.subscriptions.create'); 
    
    // PaymentMethod
    Route::post('/payment_methods' , [PaymentMethodController::class, 'create'])->name('api.payment_methods.create'); 
    Route::get('/payment_methods/{payment_method_id}' , [PaymentMethodController::class, 'retrieve'])->name('api.donors.payment_methods.retrieve'); 
    Route::delete('/payment_methods/{payment_method_id}' , [PaymentMethodController::class, 'delete'])->name('api.payment_methods.delete'); 
    
    // Stripe Routes
    Route::post('/payment_providers/stripe/setup_intents' , [SetupIntentController::class, 'create'])->name('api.payment_providers.stripe.setup_intent.create'); 
    
    //Like
    Route::post('/likes' , [LikeController::class, 'create'])->name('api.likes.create'); 
    Route::delete('/likes/{id}' , [LikeController::class, 'delete'])->name('api.likes.delete');
  
    //Comment
    Route::post('/comments' , [CommentController::class, 'create'])->name('api.comments.create'); 
    Route::delete('/comments/{id}' , [CommentController::class, 'delete'])->name('api.comments.delete');
    


});