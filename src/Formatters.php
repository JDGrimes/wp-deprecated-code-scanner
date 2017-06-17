<?php

/**
 * Formatters class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

use WP_Deprecated_Code_Scanner\Formatter\Formatter;

/**
 * Holds a collection of output formatters.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */
class Formatters {

	/**
	 * The formatters.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	protected $formatters = [];

	/**
	 * Registers a formatter.
	 *
	 * @since 0.1.0
	 *
	 * @param string    $name      The formatter slug.
	 * @param Formatter $formatter The formatter object.
	 */
	public function add( $name, Formatter $formatter ) {
		$this->formatters[ $name ] = $formatter;
	}

	/**
	 * Returns a formatter object by name.
	 *
	 * @since 0.1.0
	 *
	 * @param string $name The formatter slug.
	 *
	 * @return false|Formatter The formatter, or false if not found.
	 */
	public function get( $name ) {

		if ( ! isset( $this->formatters[ $name ] ) ) {
			return false;
		}

		return $this->formatters[ $name ];
	}
}

// EOF
