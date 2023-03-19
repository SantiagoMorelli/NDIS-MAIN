<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Response;

class HttpsAllow {
	
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
		// if ($_SERVER['REQUEST_SCHEME'] == config('ndis.httpsallow')) {
			return $next($request);
		// }
		// return $this->errorResponse(trans('only access with https url'), Response::HTTP_NOT_FOUND);
	}

}
