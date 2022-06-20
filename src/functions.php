<?php
/**
 * Helper functions
 *
 * @since   0.1.0
 * @license GPL-2.0-or-later
 * @package Pressody
 */

declare ( strict_types=1 );

namespace Pressody\PartTemplate;

/**
 * Retrieve the main plugin instance.
 *
 * @since 0.1.0
 *
 * @return Plugin
 */
function plugin(): Plugin {
	static $instance;
	$instance = $instance ?: new Plugin();

	return $instance;
}

/**
 * Autoload mapped classes.
 *
 * @since 0.1.0
 *
 * @param string $class Class name.
 */
function autoloader_classmap( string $class ) {
	$class_map = [];

	if ( isset( $class_map[ $class ] ) ) {
		require_once $class_map[ $class ];
	}
}

/**
 * Generate a random string.
 *
 * @since 0.1.0
 *
 * @param int $length Length of the string to generate.
 *
 * @throws \Exception
 * @return string
 */
function generate_random_string( int $length = 12 ): string {
	$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';

	$str = '';
	$max = \strlen( $chars ) - 1;
	for ( $i = 0; $i < $length; $i ++ ) {
		$str .= $chars[ random_int( 0, $max ) ];
	}

	return $str;
}

/**
 * Display a notice about missing dependencies.
 *
 * @since 0.1.0
 */
function display_missing_dependencies_notice() {
	$message = sprintf(
	/* translators: %s: documentation URL */
		__( 'Pressody Part Template is missing required dependencies. <a href="%s" target="_blank" rel="noopener noreferer">Learn more.</a>', 'pressody_part_template' ),
		'https://github.com/pressody/pressody-part-template/blob/master/docs/installation.md'
	);

	printf(
		'<div class="pressody_part_template-compatibility-notice notice notice-error"><p>%s</p></div>',
		wp_kses(
			$message,
			[
				'a' => [
					'href'   => true,
					'rel'    => true,
					'target' => true,
				],
			]
		)
	);
}

/**
 * Whether debug mode is enabled.
 *
 * @since 0.1.0
 *
 * @return bool
 */
function is_debug_mode(): bool {
	return \defined( 'WP_DEBUG' ) && true === WP_DEBUG;
}

function doing_it_wrong( $function, $message, $version ) {
	// @codingStandardsIgnoreStart
	$message .= ' Backtrace: ' . wp_debug_backtrace_summary();

	if ( wp_doing_ajax() || is_rest_request() ) {
		do_action( 'doing_it_wrong_run', $function, $message, $version );
		error_log( "{$function} was called incorrectly. {$message}. This message was added in version {$version}." );
	} else {
		_doing_it_wrong( $function, $message, $version );
	}
}

function is_rest_request() {
	if ( empty( $_SERVER['REQUEST_URI'] ) ) {
		return false;
	}

	$rest_prefix         = trailingslashit( rest_get_url_prefix() );
	$is_rest_api_request = ( false !== strpos( $_SERVER['REQUEST_URI'], $rest_prefix ) ); // phpcs:disable WordPress.Security.ValidatedSanitizedInput.MissingUnslash, WordPress.Security.ValidatedSanitizedInput.InputNotSanitized

	return apply_filters( 'pressody_part_template/is_rest_api_request', $is_rest_api_request );
}

/**
 * Whether we are running unit tests.
 *
 * @since 0.1.0
 *
 * @return bool
 */
function is_running_unit_tests(): bool {
	return \defined( 'Pressody\PartTemplate\RUNNING_UNIT_TESTS' ) && true === RUNNING_UNIT_TESTS;
}

/**
 * Test if a given URL is one that we identify as a local/development site.
 *
 * @since 0.1.0
 *
 * @return bool
 */
function is_dev_url( string $url ): bool {
	// Local/development url parts to match for
	$devsite_needles = array(
		'localhost',
		':8888',
		'.local',
		':8082',
		'staging.',
	);

	foreach ( $devsite_needles as $needle ) {
		if ( false !== strpos( $url, $needle ) ) {
			return true;
		}
	}

	return false;
}

/**
 * Preload REST API data.
 *
 * @since 0.1.0
 *
 * @param array $paths Array of REST paths.
 */
function preload_rest_data( array $paths ) {
	$preload_data = array_reduce(
		$paths,
		'rest_preload_api_request',
		[]
	);

	wp_add_inline_script(
		'wp-api-fetch',
		sprintf( 'wp.apiFetch.use( wp.apiFetch.createPreloadingMiddleware( %s ) );', wp_json_encode( $preload_data ) ),
		'after'
	);
}

/**
 * Helper to easily make an internal REST API call.
 *
 * Started with the code from @link https://wpscholar.com/blog/internal-wp-rest-api-calls/
 *
 * @param string $route              Request route.
 * @param string $method             Request method. Default GET.
 * @param array  $query_params       Request query parameters. Default empty array.
 * @param array  $body_params        Request body parameters. Default empty array.
 * @param array  $request_attributes Request attributes. Default empty array.
 *
 * @return mixed The response data on success or error details.
 */
function local_rest_call( string $route, string $method = 'GET', array $query_params = [], array $body_params = [], array $request_attributes = [] ) {
	$request = new \WP_REST_Request( $method, $route, $request_attributes );

	if ( $query_params ) {
		$request->set_query_params( $query_params );
	}
	if ( $body_params ) {
		$request->set_body_params( $body_params );
	}

	$response = rest_do_request( $request );
	$server   = rest_get_server();

	return $server->response_to_data( $response, false );
}
