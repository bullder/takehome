<?php

declare( strict_types=1 );

namespace App;

// TODO: Improve the readability of this file through refactoring and documentation.

use App\Service\WordCounter;

class App {
	public const STRING PATH = 'articles';

	/**
	 * @param Article $article
	 * @return void
	 */
	final public function save( Article $article ): void {
		error_log( "Saving article $article->title, success!" );
		$result = file_put_contents( self::filePath( $article->title ), $article->body );
		if ( !$result ) {
			throw new \RuntimeException( 'Unable to save file' );
		}

		( new WordCounter( $this ) )->count();
	}

	/**
	 * @param Article $article
	 * @return void
	 */
	final public function update( Article $article ): void {
		$this->save( $article );
	}

	/**
	 * @param string $title
	 * @return Article
	 */
	final public function fetch( string $title ): Article {
		$title = Article::cleanString( $title );
		$body = file_get_contents( self::filePath( $title ) );
		if ( $body ) {
			return new Article( $title, $body );
		}

		throw new \RuntimeException( 'Unable to find file' );
	}

	/**
	 * @return array
	 */
	final public function getListOfArticles(): array {
		return array_values( array_diff( scandir( self::PATH ), [ '.', '..', '.DS_Store' ] ) );
	}

	/**
	 * @param string $search
	 * @return array
	 */
	final public function search( string $search ): array {
		$search = strtolower( $search );
		$list = $this->getListOfArticles();
		$ma = [];
		foreach ( $list as $ar ) {
			if ( stripos( strtolower( $ar ), $search ) === 0 ) {
				$ma[] = $ar;
			}
		}

		return $ma;
	}

	/**
	 * @param string $title
	 * @return string
	 */
	public static function filePath( string $title ): string {
		return __DIR__ . DIRECTORY_SEPARATOR .
			'..' . DIRECTORY_SEPARATOR .
			self::PATH . DIRECTORY_SEPARATOR .
			$title;
	}
}
