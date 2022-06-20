<?php
/**
 * Main plugin class
 *
 * @since   0.1.0
 * @license GPL-2.0-or-later
 * @package Pressody
 */

declare ( strict_types=1 );

namespace Pressody\PartTemplate;

use Cedaro\WP\Plugin\Plugin as BasePlugin;
use Psr\Container\ContainerInterface;

/**
 * Main plugin class - composition root.
 *
 * @since 0.1.0
 */
class Plugin extends BasePlugin implements Composable {
	/**
	 * Compose the object graph.
	 *
	 * @since 0.1.0
	 */
	public function compose() {
		$container = $this->get_container();

		/**
		 * Start composing the object graph in Pressody Part Template.
		 *
		 * @since 0.1.0
		 *
		 * @param Plugin             $plugin    Main plugin instance.
		 * @param ContainerInterface $container Dependency container.
		 */
		do_action( 'pressody_part_template/compose', $this, $container );

		// Register hook providers.
		$this
			->register_hooks( $container->get( 'hooks.i18n' ) )
			->register_hooks( $container->get( 'logs.manager' ) );

		if ( is_admin() ) {
			$this
				->register_hooks( $container->get( 'hooks.upgrade' ) )
				->register_hooks( $container->get( 'hooks.admin_assets' ) );
		}

		/**
		 * Finished composing the object graph in Pressody Part Template.
		 *
		 * @since 0.1.0
		 *
		 * @param Plugin             $plugin    Main plugin instance.
		 * @param ContainerInterface $container Dependency container.
		 */
		do_action( 'pressody_part_template/composed', $this, $container );
	}

	public function define_constants(): Plugin {
		$upload_dir = wp_upload_dir( null, false );

		if ( ! defined( 'Pressody\PartTemplate\LOG_DIR' ) ) {
			define( 'Pressody\PartTemplate\LOG_DIR', $upload_dir['basedir'] . '/pressody-part-template-logs/' );
		}

		return $this;
	}
}
