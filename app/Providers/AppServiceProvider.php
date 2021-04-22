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
            'faq' => 'App\Models\Faq',
            'publisher' => 'App\Models\Publisher',
            'blog' => 'App\Models\Blog',
            'page' => 'App\Models\Page',
            'shortcut' => 'App\Models\Shortcut',
            'shortcutkey' => 'App\Models\ShortcutKey',
            'constant' => 'App\Models\Constant',
        ]);
    }
}
