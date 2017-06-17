<?php

/**
 * Config class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

/**
 * Holds configuration for the scanner.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */
class Config {

	/**
	 * The functions to search for that indicate a deprecated element.
	 *
	 * @since 0.1.0
	 *
	 * @var array[]
	 */
	protected $functions = [
		'_deprecated_function' => [
			'type'        => 'function',
			'version_arg' => 1,
			'alt_arg'     => 2,
		],
	];

	/**
	 * Returns the list of functions that indicate a deprecated element.
	 *
	 * @since 0.1.0
	 *
	 * @return array[]
	 */
	public function get_functions() {
		return $this->functions;
	}
}

// EOF
