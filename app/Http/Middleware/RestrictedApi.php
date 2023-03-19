<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class RestrictedApi  {
	
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
		$allowIps = explode(',', config('ndis.allow_ip_address'));
		$serverAddress = $_SERVER['SERVER_ADDR'];
		if (in_array($serverAddress, $allowIps)) {
			return $next($request);
		}
		Log::info($serverAddress);
		return $this->errorResponse(trans("You can't perform this action"), Response::HTTP_NOT_FOUND);
	}

}
