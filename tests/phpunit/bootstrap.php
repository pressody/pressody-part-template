<?php
declare ( strict_types = 1 );

use PixelgradeLT\PartTemplate\Tests\Framework\PHPUnitUtil;
use PixelgradeLT\PartTemplate\Tests\Framework\TestSuite;
use Psr\Log\NullLogger;

require dirname( __DIR__, 2 ) . '/vendor/autoload.php';

define( 'PixelgradeLT\PartTemplate\RUNNING_UNIT_TESTS', true );
define( 'PixelgradeLT\PartTemplate\TESTS_DIR', __DIR__ );
define( 'WP_PLUGIN_DIR', __DIR__ . '/Fixture/wp-content/plugins' );

if ( 'Unit' === PHPUnitUtil::get_current_suite() ) {
	// For the Unit suite we shouldn't need WordPress loaded.
	// This keeps them fast.
	return;
}

require_once dirname( __DIR__, 2 ) . '/vendor/antecedent/patchwork/Patchwork.php';

$suite = new TestSuite();

$GLOBALS['wp_tests_options'] = [
	'active_plugins'  => [ 'pixelgradelt-part-template/pixelgradelt-part-template.php' ],
	'timezone_string' => 'Europe/Bucharest',
];

$suite->addFilter( 'muplugins_loaded', function() {
	require dirname( __DIR__, 2 ) . '/pixelgradelt-part-template.php';
} );

$suite->addFilter( 'pixelgradelt_part_template/compose', function( $plugin, $container ) {
	$container['logger'] = new NullLogger();
}, 10, 2 );

$suite->bootstrap();
