<?php

declare( strict_types=1 );

namespace App;

readonly class Article {
	/**
	 * @param string $title
	 * @param string $body
	 */
	public function __construct(
		public string $title,
		public string $body
	) {
	}

	/**
	 * @return int
	 */
	final public function getWordCount(): int {
		return count( explode( ' ', $this->body ) ) ?? 0;
	}

	/**
	 * @return array
	 */
	final public function toArray(): array {
		return [
			'title' => $this->title,
			'body' => $this->body
		];
	}

	/**
	 * @param string $string
	 * @return string
	 */
	public static function cleanString( string $string ): string {
		$string = htmlentities( $string );

		return preg_replace( '/[^a-zA-Z0-9]/', '', $string );
	}
}
