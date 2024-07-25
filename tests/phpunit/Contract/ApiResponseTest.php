<?php

declare( strict_types=1 );

namespace Tests\Contract;

use App\Contract\ApiResponse;
use PHPUnit\Framework\TestCase;

/**
 * @coversDefaultClass \App\Contract\ApiResponse
 */
final class ApiResponseTest extends TestCase {
	/**
	 * @covers ::__construct
	 */
	public function testConstructorSetsPayload(): void {
		$apiResponse = new ApiResponse( self::getPayload() );

		$this->assertSame( self::getPayload(), self::getPrivateProperty( $apiResponse ) );
	}

	/**
	 * @covers ::toJson
	 */
	public function testToJson(): void {
		$apiResponse = new ApiResponse( self::getPayload() );

		$expectedJson = json_encode( [ 'content' => self::getPayload() ] );

		$this->assertSame( $expectedJson, $apiResponse->toJson() );
	}

	private static function getPayload(): array {
		return [ 'key' => 'value' ];
	}

	private static function getPrivateProperty( object $object ): mixed {
		$reflection = new \ReflectionClass( $object );
		$property = $reflection->getProperty( 'payload' );
		$property->setAccessible( true );

		return $property->getValue( $object );
	}
}
