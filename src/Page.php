<?php

declare( strict_types=1 );

namespace App;

readonly class Page {
	/**
	 * @var string
	 */
	public string $title;

	/**
	 * @var string
	 */
	public string $body;

	/**
	 * @var string
	 */
	public string $articlesList;

	/**
	 * @param Article|null $article
	 * @param array $articles
	 * @param int $wordCount
	 */
	public function __construct(
		public ?Article $article,
		public array $articles,
		public int $wordCount
	) {
		if ( $this->article ) {
			$this->title = $this->article->title;
			$this->body = $this->article->body;
		} else {
			$this->title = 'Article editor';
			$this->body = '';
		}
		$this->articlesList = self::renderArticles( $this->articles );
	}

	/**
	 * @param array $articles
	 * @return string
	 */
	private static function renderArticles( array $articles ): string {
		$nodes = '';
		foreach ( $articles as $article ) {
			$nodes .= "<li><a href='index.php?title=$article'>$article</a></li>" . PHP_EOL;
		}

		return $nodes;
	}
}
