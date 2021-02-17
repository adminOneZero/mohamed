<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

use Closure;
use Illuminate\Http\Request;

class SellerCheck
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
            if (Auth::check()) {
                # code...
                $account_type = Auth::user()->account_type;
                $view = Auth::user()->view;
                if (Auth::check() AND $account_type == 'seller' OR $account_type == 'admin') {
                    return $next($request);
                }
                if ($view != 1 AND $account_type == 'seller' AND $account_type != 'admin') {
                    # code...
                    notify("هذا الحساب غير نشط","Toast","danger");
                    
                }
                return redirect('/dashboard');
            }else{
                return redirect('/login');
            }
        } catch (\Throwable $th) {
            //throw $th;
            return redirect('/login');
        }
    }
}
