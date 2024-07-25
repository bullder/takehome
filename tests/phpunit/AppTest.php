<?php

declare( strict_types=1 );

namespace Tests;

use App\App;

/**
 * @coversDefaultClass App
 */
class AppTest extends \PHPUnit\Framework\TestCase {

	/**
	 * @covers ::fetch
	 */
	final public function testFetch() {
		$app = new App();
		$x = $app->fetch( 'Foo' );
		$this->assertStringContainsString( 'Use of metasyntactic variables', $x->body );
	}
}
