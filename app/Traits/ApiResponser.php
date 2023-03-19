<?php

namespace App\Traits;

trait ApiResponser
{

	/**
	 * Build success responses.
	 *
	 * @param string $message
	 * @param int $code
	 * @param array $data
	 * @return Illuminate\Http\JsonResponse
	 */
	public function successResponse($message, $code, $data = '') {
		$status = 'success';
		$params = [$status => $code, 'message' => $message];
		if (!empty(($data))) {
			$params = [$status => $code, 'message' => $message, 'data' => $data];
		}
		return response()->json($params);
	}

	/**
	 * Build error responses.
	 *
	 * @param string $message
	 * @param int $code
	 * @return Illuminate\Http\JsonResponse
	 */
	public function errorResponse($message, $code) {
		$status = 'error';
		$params = [$status => $code, 'message' => $message];
		return response()->json($params);
	}

	/**
	 * Build error responses.
	 *
	 * @param string|array $message
	 * @param int $code
	 * @return Illuminate\Http\Response
	 */
	public function errorMessage($message, $code) {
		return response($message, $code)->header('Content-Type', 'application/json');
	}

	/**
	 * Note this function is same as the below function but instead of errorResponse with error below function returns error json.
	 *
	 * Throw Validation.
	 * @param string $message
	 * @param int $code
	 * @return mix
	 */
	public function throwValidation($message, $code) {
		return $this->errorResponse($message, $code);
	}

	/**
	 * Build order responses.
	 *
	 * @param string $status
	 * @param int $code
	 * @return Illuminate\Http\JsonResponse
	 */
	public function orderResponse($status, $code) {
		$params = ['Order Status' => $status, 'Error Code' => $code];
		return response()->json($params);
	}

}
