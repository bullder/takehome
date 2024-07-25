<?php

declare( strict_types=1 );

namespace Tests\Contract;

use App\Contract\ApiRequest;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass ApiRequest
 */
final class ApiRequestTest extends TestCase {

	/**
	 * @covers ::__construct
	 */
	public function testConstructorSetsProperties(): void {
		$title = 'Test Title';
		$search = 'Test Search';

		$apiRequest = new ApiRequest( $title, $search );

		$this->assertSame( $title, $apiRequest->title );
		$this->assertSame( $search, $apiRequest->search );
	}
}
