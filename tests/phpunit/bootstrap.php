<?php
declare ( strict_types = 1 );

use Pressody\PartTemplate\Tests\Framework\PHPUnitUtil;
use Pressody\PartTemplate\Tests\Framework\TestSuite;
use Psr\Log\NullLogger;

require dirname( __DIR__, 2 ) . '/vendor/autoload.php';

define( 'Pressody\PartTemplate\RUNNING_UNIT_TESTS', true );
define( 'Pressody\PartTemplate\TESTS_DIR', __DIR__ );
define( 'WP_PLUGIN_DIR', __DIR__ . '/Fixture/wp-content/plugins' );

if ( 'Unit' === PHPUnitUtil::get_current_suite() ) {
	// For the Unit suite we shouldn't need WordPress loaded.
	// This keeps them fast.
	return;
}

require_once dirname( __DIR__, 2 ) . '/vendor/antecedent/patchwork/Patchwork.php';

$suite = new TestSuite();

$GLOBALS['wp_tests_options'] = [
	'active_plugins'  => [ 'pressody-part-template/pressody-part-template.php' ],
	'timezone_string' => 'Europe/Bucharest',
];

$suite->addFilter( 'muplugins_loaded', function() {
	require dirname( __DIR__, 2 ) . '/pressody-part-template.php';
} );

$suite->addFilter( 'pressody_part_template/compose', function( $plugin, $container ) {
	$container['logger'] = new NullLogger();
}, 10, 2 );

$suite->bootstrap();
