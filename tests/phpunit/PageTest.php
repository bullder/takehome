<?php

declare( strict_types=1 );

namespace Tests;

use App\Article;
use App\Page;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass Page
 */
final class PageTest extends TestCase {
	/**
	 * @covers ::__construct
	 */
	public function testConstructor(): void {
		$article = new Article( 'Sample Title', 'Sample Body' );
		$articles = [ 'Article 1', 'Article 2' ];
		$wordCount = 100;

		$page = new Page( $article, $articles, $wordCount );

		$this->assertSame( 'Sample Title', $page->title );
		$this->assertSame( 'Sample Body', $page->body );
		$this->assertSame( self::getExpectedArticlesList( $articles ), $page->articlesList );
		$this->assertSame( $article, $page->article );
		$this->assertSame( $articles, $page->articles );
		$this->assertSame( $wordCount, $page->wordCount );
	}

	/**
	 * @param array $articles
	 * @return string
	 */
	private static function getExpectedArticlesList( array $articles ): string {
		$nodes = '';
		foreach ( $articles as $article ) {
			$nodes .= "<li><a href='index.php?title=$article'>$article</a></li>" . PHP_EOL;
		}
		return $nodes;
	}
}
