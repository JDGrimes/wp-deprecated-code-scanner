<?php

/**
 * WPCS formatter class.
 *
 * @package WP_Deprecated_Code_Scanner
 * @since   0.1.0
 */

namespace WP_Deprecated_Code_Scanner\Formatter;

use WP_Deprecated_Code_Scanner\Collector;

/**
 * Formats output to compare with WPCS sniff.
 *
 * @package WP_Deprecated_Code_Scanner\Formatter
 * @since   0.1.0
 */
class WPCS implements Formatter {

	/**
	 * @since 0.1.0
	 */
	public function format( Collector $collector ) {

		$output = "\tprivate \$deprecated_functions = array(\n";

		$results = [];

		foreach ( $collector->get() as $item ) {
			$results[ $item['version'] ][ $item['element'] ] = $item;
		}

		ksort( $results );

		foreach ( $results as $version => $functions ) {

			$output .= "\n\t\t// {$version}\n";

			ksort( $functions );

			$functions = array_unique( $functions );

			foreach ( $functions as $function => $data ) {

				$output .= "		'{$function}' => array(
			'alt'     => '{$data['alt']}',
			'version' => '{$version}',
		),\n";
			}
		}

		$output .= "\t);\n";

		return $output;
	}
}

// EOF
