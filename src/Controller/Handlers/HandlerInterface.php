<?php

declare( strict_types=1 );

namespace App\Controller\Handlers;

use App\Contract\ApiRequest;
use App\Contract\ApiResponse;

interface HandlerInterface {
	/**
	 * @param ApiRequest $request
	 * @return bool
	 */
	public function supports( ApiRequest $request ): bool;

	/**
	 * @param ApiRequest $request
	 * @return ApiResponse
	 */
	public function handle( ApiRequest $request ): ApiResponse;
}
