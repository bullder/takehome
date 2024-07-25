<?php

declare( strict_types=1 );

namespace App\Contract;

readonly class ApiResponse {
	/**
	 * @param array $payload
	 */
	public function __construct( private array $payload ) {
	}

	/**
	 * @return string
	 */
	final public function toJson(): string {
		return json_encode( [ 'content' => $this->payload ] );
	}
}
