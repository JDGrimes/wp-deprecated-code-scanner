<?php

/**
 * Markdown formatter class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\Formatter;

use WP_Deprecated_Code_Scanner\Collector;

/**
 * Formats the list of discovered deprecated elements with markdown.
 *
 * @package WP_Deprecated_Code_Scanner\Formatter
 * @since   0.1.0
 */
class Markdown implements Formatter {

	/**
	 * @since 0.1.0
	 */
	public function format( Collector $collector ) {

		$output = '';

		$results = [];

		foreach ( $collector->get() as $item ) {
			$results[ $item['version'] ][ $item['element'] ] = $item;
		}

		ksort( $results );

		foreach ( $results as $version => $functions ) {

			$output .= "## {$version}\n";

			ksort( $functions );

			$functions = array_unique( $functions );

			foreach ( $functions as $function => $data ) {

				$message = "- `{$function}()`";

				if ( isset( $data['alt'] ) ) {
					$message .= " (use `{$data['alt']}()` instead)";
				}

				$output .= "{$message}\n";
			}

			$output .= "\n";
		}

		return $output;
	}
}

// EOF
