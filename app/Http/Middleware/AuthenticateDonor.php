<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Token;

class AuthenticateDonor
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next , $params = null)
    {
        $token = Token::where('access_token', $request->bearerToken())->first();
        if($params && $params == 'optional')
        {
            if ($token && $request->user()){
                app()->setlocale($request->user()->locale);
            }
        }else{
            if (!$token || !$request->user()) return $this->unauthenticated($request);
            app()->setlocale($request->user()->locale);

        }

        return $next($request);
    }

    private function unauthenticated()
    {
        return response()->json(['status' => 'Unauthorized'], 401);
    }

}
