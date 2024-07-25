<?php

declare( strict_types=1 );

namespace Tests\Controller;

use App\App;
use App\Contract\ApiRequest;
use App\Controller\ApiController;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass ApiController
 */
class ApiControllerTest extends TestCase {
	/**
	 * @covers ::action
	 * @dataProvider actionProvider
	 */
	final public function testAction( ApiRequest $request, string $expected ): void {
		$controller = new ApiController( new App() );
		$json = $controller->action( $request )->toJson();

		$this->assertSame( $expected, $json );
	}

	/**
	 * @return array
	 */
	private function actionProvider(): array {
		return [
			'search' => [ new ApiRequest( '', 'Bla' ), '{"content":["Blah"]}' ],
			'article' => [ new ApiRequest( 'Blah', '' ), '{"content":{"title":"Blah","body":"Blah"}}' ],
			'default' => [ new ApiRequest( '', '' ), '{"content":["Blah","Foo"]}' ],
		];
	}
}
