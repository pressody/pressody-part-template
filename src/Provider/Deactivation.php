<?php
/**
 * Plugin deactivation routines.
 *
 * @package Pressody
 * @license GPL-2.0-or-later
 * @since 0.1.0
 */

declare ( strict_types = 1 );

namespace Pressody\PartTemplate\Provider;

use Cedaro\WP\Plugin\AbstractHookProvider;

/**
 * Class to deactivate the plugin.
 *
 * @since 0.1.0
 */
class Deactivation extends AbstractHookProvider {
	/**
	 * Register hooks.
	 *
	 * @since 0.1.0
	 */
	public function register_hooks() {
		register_deactivation_hook( $this->plugin->get_file(), [ $this, 'deactivate' ] );
	}

	/**
	 * Deactivation routine.
	 *
	 * @since 0.1.0
	 */
	public function deactivate() {
		// Do something when this plugin is deactivated.
	}
}
