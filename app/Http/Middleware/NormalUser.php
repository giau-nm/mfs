<?php

namespace App\Http\Middleware;

use Closure;

class NormalUser
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
        $user = \Auth::user();
        if (is_null($user)) {
            $request->session()->put('redirect_after_login', url()->current());
            return redirect(route('login'));
        }
        $request->user = $user;

        return $next($request);
    }
}
