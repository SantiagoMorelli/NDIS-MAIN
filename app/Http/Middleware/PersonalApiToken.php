<?php

namespace App\Http\Middleware;

use App\Traits\ApiResponser;
use Closure;
use Illuminate\Http\Response;
use App\Models\PersonalAccessTokens;

class PersonalApiToken {
	
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
		$token = $request->header('Authorization');
		if ($token) {
			$personalToken = PersonalAccessTokens::where('name', 'magento')->first();
			if (isset($personalToken->token) && $personalToken->token == $token) {
				return $next($request);
			} else {
            	return $this->errorResponse(trans('Invalid token'), Response::HTTP_UNAUTHORIZED);
			}
			
		} else {
            return $this->errorResponse(trans('Token missing'), Response::HTTP_UNAUTHORIZED);
        }
	}

}
