<?php

/**
 * Formatter interface.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\Formatter;

use WP_Deprecated_Code_Scanner\Collector;

/**
 * Interface for output formatters.
 *
 * @package WP_Deprecated_Code_Scanner\Formatter
 * @since   0.1.0
 */
interface Formatter {

	/**
	 * Formats the list of deprecated elements.
	 *
	 * @since 0.1.0
	 *
	 * @param Collector $collector The collection of deprecated elements.
	 *
	 * @return string The formatted output.
	 */
	public function format( Collector $collector );
}

// EOF
