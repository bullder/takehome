<?php

declare( strict_types=1 );

namespace App\Controller\Handlers;

use App\Contract\ApiRequest;
use App\Contract\ApiResponse;

class DefaultHandler extends AbstractHandler implements HandlerInterface {
	/**
	 * @param ApiRequest $request
	 * @return bool
	 */
	final public function supports( ApiRequest $request ): bool {
		return true;
	}

	/**
	 * @param ApiRequest $request
	 * @return ApiResponse
	 */
	final public function handle( ApiRequest $request ): ApiResponse {
		return new ApiResponse( $this->app->getListOfArticles() );
	}
}
