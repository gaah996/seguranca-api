<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\DB;

class ClientAuthorizationProxy
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if($request->header('client-id') && $request->header('client-secret')) {
            $client = DB::table('oauth_clients')->
                where('id', $request->header('client-id'))->
                where('secret', $request->header('client-secret'))->
                first();

            if($client) {
                return $next($request);
            } else {
                return response()->JSON(['error' => 'Client Not Authorized'], 401);
            }
        } else {
            return response()->JSON(['error' => 'Client Not Authorized'], 401);
        }
    }
}
