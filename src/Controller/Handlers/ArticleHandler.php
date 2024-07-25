<?php

declare( strict_types=1 );

namespace App\Controller\Handlers;

use App\Contract\ApiRequest;
use App\Contract\ApiResponse;

class ArticleHandler extends AbstractHandler implements HandlerInterface {
	/**
	 * @param ApiRequest $request
	 *
	 * @return bool
	 */
	final public function supports( ApiRequest $request ): bool {
		return !empty( $request->title );
	}

	/**
	 * @param ApiRequest $request
	 *
	 * @return ApiResponse
	 */
	final public function handle( ApiRequest $request ): ApiResponse {
		return new ApiResponse( $this->app->fetch( $request->title )->toArray() );
	}
}
