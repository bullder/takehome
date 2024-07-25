<?php

declare( strict_types=1 );

namespace App\Contract;

readonly class ApiRequest {

	/**
	 * @param string $title
	 * @param string $search
	 */
	public function __construct( public string $title, public string $search ) {
	}

	/**
	 * @return ApiRequest
	 */
	public static function fromGlobals(): ApiRequest {
		return new self(
			filter_input( INPUT_GET, 'title', FILTER_SANITIZE_SPECIAL_CHARS ) ?? '',
			filter_input( INPUT_GET, 'prefixsearch', FILTER_SANITIZE_SPECIAL_CHARS ) ?? ''
		);
	}
}
