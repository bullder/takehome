<?php

declare( strict_types=1 );

namespace App\Controller\Handlers;

use App\App;

abstract class AbstractHandler {
	/**
	 * @var App
	 */
	protected App $app;

	/**
	 * @param App $app
	 */
	public function __construct( App $app ) {
		$this->app = $app;
	}
}
