<?php

declare( strict_types=1 );

namespace Tests;

use App\App;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass App
 */
class AppTest extends TestCase {

	/**
	 * @covers ::fetch
	 */
	final public function testFetch(): void {
		$app = new App();
		$x = $app->fetch( 'Foo' );
		$this->assertStringContainsString( 'Use of metasyntactic variables', $x->body );
	}
}
