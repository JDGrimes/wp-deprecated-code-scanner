<?php

/**
 * Collector class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner;

/**
 * Used to collect a list of deprecated elements.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */
class Collector {

	/**
	 * The deprecated elements.
	 *
	 * @since 0.1.0
	 *
	 * @var array
	 */
	protected $elements = [];

	/**
	 * Adds an element to the list.
	 *
	 * @since 0.1.0
	 *
	 * @param string $element The element name.
	 * @param string $type    The type of element this is.
	 * @param string $version The version this element was deprecated.
	 * @param string $alt     The alternative, if any.
	 */
	public function add( $element, $type, $version, $alt = null ) {
		$this->elements[] = [
			'element' => $element,
			'version' => $version,
			'alt'     => $alt,
			'type'    => $type,
		];
	}

	/**
	 * Returns the list of all deprecated elements collected.
	 *
	 * @since 0.1.0
	 *
	 * @return array
	 */
	public function get() {
		return $this->elements;
	}
}

// EOF
