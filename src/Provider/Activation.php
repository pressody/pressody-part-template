<?php
/**
 * Plugin activation routines.
 *
 * @package Pressody
 * @license GPL-2.0-or-later
 * @since 0.1.0
 */

declare ( strict_types = 1 );

namespace Pressody\PartTemplate\Provider;

use Cedaro\WP\Plugin\AbstractHookProvider;

/**
 * Class to activate the plugin.
 *
 * @since 0.1.0
 */
class Activation extends AbstractHookProvider {

	/**
	 * Register hooks.
	 *
	 * @since 0.1.0
	 */
	public function register_hooks() {
		register_activation_hook( $this->plugin->get_file(), [ $this, 'activate' ] );
	}

	/**
	 * Activate the plugin.
	 *
	 * @since 0.1.0
	 */
	public function activate() {
		// Do something when this plugin is activated (runs on upgrade also).
	}
}
