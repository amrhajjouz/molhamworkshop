<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\Token;
use Illuminate\Support\Facades\Auth;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        //

        $token = Token::where('api_token', request()->bearerToken())->first();

        if($token){
            $this->app->rebinding('request', function ($app, $request) use ($token) {
                $request->setUserResolver(function ($guard = null) use ($app , $request , $token) {
                    if ($request->bearerToken()) {
                        return $token->tokenable ?? null;
                    }
                    return null;
                });
    
                Auth::viaRequest('custom-token', function ($request) use($token){
                    return $token->tokenable ??  null;
                });
    
            });
        }


    }
}
