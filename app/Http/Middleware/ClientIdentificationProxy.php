<?php

namespace App\Http\Middleware;

use Closure;

class ClientIdentificationProxy
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
        $request['ip'] = $request->ip();
        if($request->ip() == '162.144.72.199') {
            $request->headers->set('client-id', 4);
            $request->headers->set('client-secret', 'wWV5Vm9qubeDk3MGcosoiMsapCylWfS0zk9Nrn1f');
        }
        return $next($request);
    }
}
