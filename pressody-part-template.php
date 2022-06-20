<?php
/**
 * Pressody Part Template Title
 *
 * @package Pressody
 * @author  Vlad Olaru <vladpotter85@gmail.com>
 * @license GPL-2.0-or-later
 *
 * @wordpress-plugin
 * Plugin Name: Pressody Part Template Title
 * Plugin URI: https://github.com/pressody/pressody-part-template
 * Description: Handles the custom integration for the Pressody Part.
 * Version: 0.2.0
 * Author: Pressody
 * Author URI: https://getpressody.com/
 * License: GPL-2.0-or-later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: pressody_part_template
 * Domain Path: /languages
 * Requires PHP: 7.4
 * Network: false
 * GitHub Plugin URI: pressody/pressody-part-template
 * Release Asset: true
 */

declare ( strict_types=1 );

namespace Pressody\PartTemplate;

// Exit if accessed directly.
if ( ! \defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Plugin version.
 *
 * @var string
 */
const VERSION = '0.1.0';

// Load the Composer autoloader.
if ( file_exists( __DIR__ . '/vendor/autoload.php' ) ) {
	require __DIR__ . '/vendor/autoload.php';
}

// Display a notice and bail if dependencies are missing.
if ( ! function_exists( __NAMESPACE__ . '\autoloader_classmap' ) ) {
	require_once __DIR__ . '/src/functions.php';
	add_action( 'admin_notices', __NAMESPACE__ . '\display_missing_dependencies_notice' );

	return;
}

// Autoload mapped classes.
spl_autoload_register( __NAMESPACE__ . '\autoloader_classmap' );

// Read environment variables from the $_ENV array also.
\Env\Env::$options |= \Env\Env::USE_ENV_ARRAY;

// Load the WordPress plugin administration API.
require_once ABSPATH . 'wp-admin/includes/plugin.php';

// Create a container and register a service provider.
$pressody_part_template_container = new Container();
$pressody_part_template_container->register( new ServiceProvider() );

// Initialize the plugin and inject the container.
$pressody_part_template = plugin()
	->set_basename( plugin_basename( __FILE__ ) )
	->set_directory( plugin_dir_path( __FILE__ ) )
	->set_file( __DIR__ . '/pressody-part-template.php' )
	->set_slug( 'pressody-part-template' )
	->set_url( plugin_dir_url( __FILE__ ) )
	->define_constants()
	->set_container( $pressody_part_template_container )
	->register_hooks( $pressody_part_template_container->get( 'hooks.activation' ) )
	->register_hooks( $pressody_part_template_container->get( 'hooks.deactivation' ) );

add_action( 'plugins_loaded', [ $pressody_part_template, 'compose' ], 5 );
