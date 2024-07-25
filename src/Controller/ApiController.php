<?php

declare( strict_types=1 );

namespace App\Controller;

use App\App;
use App\Contract\ApiRequest;
use App\Contract\ApiResponse;
use App\Controller\Handlers\ArticleHandler;
use App\Controller\Handlers\DefaultHandler;
use App\Controller\Handlers\SearchHandler;
use LogicException;

class ApiController {
	/**
	 * @var array
	 */
	private array $handlers;

	/**
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->handlers = [
			new ArticleHandler( $app ),
			new SearchHandler( $app ),
			new DefaultHandler( $app )
		];
	}

	/**
	 * @param ApiRequest $request
	 *
	 * @return ApiResponse
	 */
	final public function action( ApiRequest $request ): ApiResponse {
		foreach ( $this->handlers as $handler ) {
			if ( $handler->supports( $request ) ) {
				return $handler->handle( $request );
			}
		}

		throw new LogicException( 'no suitable handler' );
	}
}
