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
        Relation::morphMap([
            'cases' => 'App\Models\Cases',
            'target' => 'App\Models\Target',
            'place' => 'App\Models\Place',
            'donor' => 'App\Models\Donor',
            'social_media_posts' => 'App\Models\SocialMediaPost',
        ]);
    }
}
