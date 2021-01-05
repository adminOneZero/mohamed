<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;
use Illuminate\Http\Request;
use App\Models\User;
class AdminCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        try {
            //code...
            // $account_type = Auth::user()->account_type;
            if (Auth::check() && Auth::user()->account_type == 'admin') {
                return $next($request);
            }
            return back();
        } catch (\Throwable $th) {
            return route('login');
        }
    }
}
