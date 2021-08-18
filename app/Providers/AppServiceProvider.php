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
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
        Relation::morphMap([
            'user' => 'App\Models\User',
            'donor' => 'App\Models\Donor',
            'notification' => 'App\Models\Notification',
            'notification_template' => 'App\Models\NotificationTemplate',
        ]);
    }
}
