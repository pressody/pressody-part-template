<?php
/**
 * Logs API - Log Object
 *
 * @since       0.1.0
 * @license     GPL-2.0-or-later
 * @package     Pressody
 */

declare ( strict_types=1 );

namespace Pressody\PartTemplate\Logging;

use Pressody\PartTemplate\BaseObject;

/**
 * Log Class.
 *
 * @since 0.1.0
 *
 * @property int    $id
 * @property int    $level
 * @property string $source
 * @property string $message
 * @property string $context
 * @property string $date_created
 */
class Log extends BaseObject {

	/**
	 * Log ID.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    int
	 */
	protected $id;

	/**
	 * Log level.
	 *
	 * @see \Pressody\PartTemplate\Logging\LogLevels
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    int
	 */
	protected $level;

	/**
	 * Log source.
	 *
	 * The place where this log was generated.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $source;

	/**
	 * Log message.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $message;

	/**
	 * Log context.
	 *
	 * Extra information related to the moment this log was generated (usually encoded JSON data).
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $context;

	/**
	 * Datetime the log was created.
	 *
	 * @since  0.1.0
	 * @access protected
	 * @var    string
	 */
	protected $date_created;
}
