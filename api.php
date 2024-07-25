<?php

declare( strict_types=1 );

use App\App;
use App\Contract\ApiRequest;
use App\Controller\ApiController;

require_once __DIR__ . '/vendor/autoload.php';

// TODO A: Improve the readability of this file through refactoring and documentation.
/// DONE. File have been refactored into Controller, Request/Response models using Handlers

// TODO B: Clean up the following code so that it's easier to see the different
// routes and handlers for the API, and simpler to add new ones.
/// DONE. To serve new type of response we can now add new handler
/// Ideally load them dynamically and order them based on priority from service container

// TODO C: If there are performance concerns in the current code, please
// add comments on how you would fix them
/// There is no limitation on amount of requested data. Ideally we should have pagination for endpoints

// TODO D: Identify any potential security vulnerabilities in this code.
/// Seems it was possible file system traversal as far as 'title' could contain unsafe symbols like '../'
/// but it is fixed. Moreover usage of super globals variables had been removed

// TODO E: Document this code to make it more understandable
// for other developers.
/// Initial code is refactored to small classes which makes it more understandable

header( 'Content-Type: application/json' );

echo ( new ApiController( new App() ) )->action( ApiRequest::fromGlobals() )->toJson();
