<?php

declare( strict_types=1 );

namespace App\Controller;

use App\App;
use App\Article;
use App\Page;
use App\Service\WordCounter;

class IndexController {
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

	final public function action(): Page {
		$article = self::fromPost();
		if ( $article ) {
			$this->app->save( $article );
		}
		$title = filter_input( INPUT_GET, 'title', FILTER_SANITIZE_SPECIAL_CHARS );

		if ( $title ) {
			$article = $this->app->fetch( $title );
		}

		return new Page(
			$article,
			$this->app->getListOfArticles(),
			( new WordCounter( $this->app ) )->wfGetWc()
		);
	}

	/**
	 * @return Article|null
	 */
	private static function fromPost(): ?Article {
		$title = filter_input( INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS );
		$body = filter_input( INPUT_POST, 'body', FILTER_SANITIZE_SPECIAL_CHARS );
		if ( !$title && !$body ) {
			return null;
		}

		return new Article( Article::cleanString( $title ), $body );
	}
}
