<?php

declare( strict_types=1 );

require_once __DIR__ . '/vendor/autoload.php';

$count = 0;
// TODO: Make the number configurable, so that one can run `php seedContent.php --limit=100`

use App\App;
use App\Article;
use joshtronic\LoremIpsum;

$app = new App();

$options = getopt( '', [ 'limit:' ] );
$limit = isset( $options['limit'] ) ? (int)$options['limit'] : 10;

$l = new LoremIpsum();
for ( $i = 0; $i < $limit; $i++ ) {
	$app->save( new Article( $l->word(), $l->paragraphs( 10 ) ) );
}

echo "generated $i articles!";
