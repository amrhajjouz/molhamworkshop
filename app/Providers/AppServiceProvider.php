<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
        Relation::morphMap([
            'user' => 'App\Models\User',
            'donor' => 'App\Models\Donor',
            'stripe_card' => 'App\Models\StripeCard',
            'swish_account' => 'App\Models\SwishAccount',
            'stripe_ideal_account' => 'App\Models\StripeIdealAccount',
            'stripe_sofort_account' => 'App\Models\StripeSofortAccount',
            'stripe_sepa_account' => 'App\Models\StripeSepaAccount',
            'stripe_giropay_account' => 'App\Models\StripeGiropayAccount',
            'paypal_subscription' => 'App\Models\PaypalSubscription',
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
