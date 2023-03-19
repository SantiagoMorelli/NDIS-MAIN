<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AdminUserAllow {
	
	use ApiResponser;

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @param  string|null  $guard
	 * @return mixed
	 */
	public function handle($request, Closure $next, $guard = null) {
		if (Auth::check()) {
			if (Auth::user()->is_admin == 1) {
				return $next($request);
			}
		}
		return redirect(route('adminDashboard'));
	}

}
