<?php

declare( strict_types=1 );

namespace App\Service;

use App\App;

class WordCounter {
	private const STRING PATH = 'stat';

	/**
	 * @var App
	 */
	private App $app;

	/**
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app = $app;
	}

	final public function wfGetWc(): int {
		$count = $this->getCached();
		if ( $count !== null ) {
			return $count;
		}

		return $this->count();
	}

	final public function count(): int {
		$wc = 0;
		foreach ( self::pathIterator() as $fileinfo ) {
			if ( $fileinfo->isDot() ) {
				continue;
			}
			$article = $this->app->fetch( $fileinfo->getFilename() );
			$wc += $article->getWordCount();
		}

		$this->setCached( $wc );

		return $wc;
	}

	/**
	 * @return int|null
	 */
	private function getCached(): ?int {
		if ( !file_exists( self::filePath() ) ) {
			return null;
		}
		$body = file_get_contents( self::filePath() );
		if ( $body ) {
			return (int)$body;
		}

		return null;
	}

	/**
	 * @param int $count
	 * @return void
	 */
	private function setCached( int $count ): void {
		file_put_contents( self::filePath(), $count );
	}

	/**
	 * @return string
	 */
	public static function filePath(): string {
		return __DIR__ . DIRECTORY_SEPARATOR .
			'..' . DIRECTORY_SEPARATOR .
			'..' . DIRECTORY_SEPARATOR .
			self::PATH;
	}

	/**
	 * @return \DirectoryIterator
	 */
	private static function pathIterator(): \DirectoryIterator {
		return new \DirectoryIterator( App::PATH . DIRECTORY_SEPARATOR );
	}
}
