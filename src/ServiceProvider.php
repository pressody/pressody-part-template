<?php
/**
 * Plugin service definitions.
 *
 * @since   0.1.0
 * @license GPL-2.0-or-later
 * @package PixelgradeLT
 */

declare ( strict_types=1 );

namespace PixelgradeLT\PartTemplate;

use Cedaro\WP\Plugin\Provider\I18n;
use Pimple\Container as PimpleContainer;
use Pimple\ServiceProviderInterface;
use PixelgradeLT\PartTemplate\Logging\Handler\FileLogHandler;
use PixelgradeLT\PartTemplate\Logging\Logger;
use PixelgradeLT\PartTemplate\Logging\LogsManager;
use Psr\Log\LogLevel;
use PixelgradeLT\PartTemplate\Provider;

/**
 * Plugin service provider class.
 *
 * @since 0.1.0
 */
class ServiceProvider implements ServiceProviderInterface {
	/**
	 * Register services.
	 *
	 * @param PimpleContainer $container Container instance.
	 */
	public function register( PimpleContainer $container ) {

		$container['hooks.activation'] = function () {
			return new Provider\Activation();
		};

		$container['hooks.admin_assets'] = function () {
			return new Provider\AdminAssets();
		};

		$container['hooks.deactivation'] = function () {
			return new Provider\Deactivation();
		};

		$container['hooks.i18n'] = function () {
			return new I18n();
		};

		$container['hooks.upgrade'] = function ( $container ) {
			return new Provider\Upgrade(
				$container['logs.logger']
			);
		};

		$container['logs.logger'] = function ( $container ) {
			return new Logger(
				$container['logs.level'],
				[
					$container['logs.handlers.file'],
				]
			);
		};

		$container['logs.level'] = function () {
			// Log warnings and above when WP_DEBUG is enabled.
			if ( defined( 'WP_DEBUG' ) && WP_DEBUG ) {
				$level = LogLevel::WARNING;
			}

			return $level ?? '';
		};

		$container['logs.handlers.file'] = function () {
			return new FileLogHandler();
		};

		$container['logs.manager'] = function ( $container ) {
			return new LogsManager( $container['logs.logger'] );
		};
	}
}
